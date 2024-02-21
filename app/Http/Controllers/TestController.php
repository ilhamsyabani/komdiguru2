<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Result;
use App\Models\Category;
use App\Models\Range;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\CategoryResult;
use App\Models\QuestionResult;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateTestRequest;
use App\Models\Content;
use App\Models\Rule;

class TestController extends Controller
{

    public function index()
    {
        $rule = Rule::find(1);
        $user = auth()->user();
        $results = Result::where('user_id', $user->id)->get();

        $latestPost = $results->filter(function ($item) {
            return $item->updated_at !== null;
        })->sortByDesc('updated_at')->first();

        $interval = null;
        if ($latestPost) {
            $today = now();
            $interval = $today->diff($latestPost->updated_at);
        }

        $instansi = auth()->user()->instansion;

        if (!$instansi || !$instansi->isActive) {
            return view('survey.waiting');
        }

        if ($rule->status && $results->count() >= $rule->filling_limit) {
            return view('survey.waiting');
        }


        if ($interval && $interval->days <= $rule->alowed_time) {
            return view('survey.waiting');
        }

        $categories = Category::whereHas('questions.options')->get();
        $categories->each(function ($category) {
            $category->questions->each(function ($question) {
                $question->options = $question->options->shuffle();
            });
        });
        return view('survey.test', compact('categories'));
    }


    public function guides()
    {
        $content = Content::find(3);
        return view('survey.guides', compact('content'));
    }

    public function edit($result_id)
    {
        $result = Result::whereHas('user', function ($query) {
            $query->whereId(auth()->id());
        })->findOrFail($result_id);

        $categoryRes = CategoryResult::where('result_id', $result->id)->get();

        $resultquestion = QuestionResult::whereIn('category_result_id', $categoryRes->pluck('id'))->get();

        $categories = Category::whereHas('categoryQuestions')
            ->get();

        return view('survey.edit', [
            'result' => $result,
            'categoriresult' => $categoryRes,
            'resultquestion' => $resultquestion,
            'categories' => $categories,
        ]);
    }

    public function revisi($result_id)
    {
        $result = Result::whereHas('user', function ($query) {
            $query->whereId(auth()->id());
        })->findOrFail($result_id);

        $categoryRes = CategoryResult::where('result_id', $result->id)->get();

        $resultquestion = QuestionResult::whereIn('category_result_id', $categoryRes->pluck('id'))->get();

        $categories = Category::whereHas('categoryQuestions')
            ->get();

        return view('client.revisi', [
            'result' => $result,
            'categoriresult' => $categoryRes,
            'resultquestion' => $resultquestion,
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $options = Option::find(array_values($request->input('questions')));

        $result = auth()->user()->userResults()->create([
            'total_points' => $options->sum('points'),
            'status' => $request->aksi
        ]);

        // Temukan pertanyaan yang terkait dengan opsi yang dipilih
        $questions = Question::all();

        // Mengelompokkan pertanyaan berdasarkan kategori soal
        $questionsByCategory = $questions->groupBy('category_id');

        // Menyimpan data kategori hasil tes ke dalam tabel category_result
        foreach ($questionsByCategory as $categoryId => $categoryQuestions) {
            $totalPoints = 0;
            $number = 0;
            $feedback = [];

            foreach ($categoryQuestions as $question) {

                $selectedOptionId = $request->input('questions')[$question->id];
                $selectedOption = $options->where('id', $selectedOptionId)->first();
                if ($selectedOption) {
                    $totalPoints += $selectedOption->points;
                } else {
                    $totalPoints += 0;
                }
                $number += 1;
            }

            $rawfeedback = Range::where('category_id', $categoryId)
                ->where('min', '<=', $totalPoints)
                ->where('max', '>=', $totalPoints)
                ->first();


            // Mengganti perbandingan ini dengan jumlah pertanyaan sebenarnya dalam kategori
            $jumlahPertanyaan = Question::where('category_id', $categoryId)->count();

            if ($number === $jumlahPertanyaan) {
                $feedback = $rawfeedback;
            } else {
                $feedback = Range::find(1);
            }

            $categoryResult = new CategoryResult([
                'total_points' => $totalPoints,
                'status' => $request->aksi,
            ]);

            // Menyimpan ID hasil tes dan ID feedback ke dalam tabel category_result
            $categoryResult->result()->associate($result);
            $categoryResult->range()->associate($feedback);
            $categoryResult->category()->associate($categoryId);
            $categoryResult->save();


            foreach ($categoryQuestions as $question) {

                $selectedOptionId = $request->input('questions')[$question->id];
                $selectedOption = Option::find($selectedOptionId);
                if ($selectedOption) {
                    $questionResult = new QuestionResult([
                        'question_id' => $question->id,
                        'option_id' => $selectedOptionId,
                        'points' => $selectedOption->points,
                    ]);
                } else {
                    $questionResult = new QuestionResult([
                        'question_id' => $question->id,
                    ]);
                }

                $questionResult->categoryResult()->associate($categoryResult);
                $questionResult->save();
            }
        }

        if ($request->aksi == "simpan") {
            return redirect()->route('survey.edit',  $result->id);
        }
        return view('survey.waiting');
    }

    public function update(Request $request, $result)
    {
        //dd($request);
        $resultData = Result::find($result);
        if ($resultData->user_id != auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Dapatkan opsi terpilih dari request
        $selectedOptions = $request->input('questions');
        $options = Option::find(array_values($request->input('questions')));

        // Temukan pertanyaan yang terkait dengan opsi yang dipilih
        $questions = Question::all();

        // Mengelompokkan pertanyaan berdasarkan kategori soal
        $questionsByCategory = $questions->groupBy('category_id');

        // Perbarui total_points pada tabel hasil ujian
        $totalPoints = Option::whereIn('id', array_values($selectedOptions))->sum('points');
        $resultData->update(['total_points' => $totalPoints]);
        $resultData->update(['status' => $request->aksi]);

        foreach ($questionsByCategory as $categoryId => $categoryQuestions) {
            $totalPoint = 0;
            $number = 0;

            foreach ($categoryQuestions as $question) {
                $selectedOptionId = $selectedOptions[$question->id];
                $selectedOption = Option::find($selectedOptionId);
                if ($selectedOption) {
                    $totalPoint += $selectedOption->points;
                }
                $number += 1;
            }

            $feedback = Range::where('category_id', $categoryId)
                ->where('min', '<=', $totalPoint)
                ->where('max', '>=', $totalPoint)
                ->first();


            // Temukan atau buat kategori hasil ujian yang sudah ada
            $categoryResult = CategoryResult::where('result_id', $result)
                ->where('category_id', $categoryId)
                ->first();

            $categoryResult->update(['total_points' => $totalPoint, 'range_id' => $feedback->id]);
            $categoryResult->save();

            foreach ($categoryQuestions as $question) {
                $selectedOptionId = $selectedOptions[$question->id];
                $selectedOption = Option::find($selectedOptionId);

                // Temukan atau buat hasil pertanyaan yang sudah ada
                if ($selectedOption) {
                    $questionResult = QuestionResult::updateOrCreate(
                        ['category_result_id' => $categoryResult->id, 'question_id' => $question->id],
                        ['option_id' => $selectedOptionId, 'points' => $selectedOption->points]
                    );
                    // Perbarui hasil pertanyaan
                    $questionResult->update(['option_id' => $selectedOptionId, 'points' => $selectedOption->points]);
                }
            }
        }
        if ($request->aksi == "simpan") {
            return redirect()->route('survey.edit',   $resultData->id);
        }
        return view('survey.waiting');
    }
}
