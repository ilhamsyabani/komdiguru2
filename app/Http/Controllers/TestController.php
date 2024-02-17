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
        $latestPost = $results->sortByDesc('updated_at')->first();
        $today = now();
        $interval = $today->diff($latestPost->updated_at);

        $instansi = auth()->user()->instansion->isActive;

        if(!$instansi ){
            
            return view('survey.waiting');
        }

        if ($rule->status) {
           

            if ($results->count() >= $rule->filling_limit) {
                return view('survey.waiting');
            }

            if ($interval->days <= $rule->alowed_time) {
                return view('survey.waiting');
            }
        }

        // Additional logic for roles (commented out for simplicity)
        // foreach ($user->roles as $role) {
        //     if ($role->title == "admin" || $role->title == "evaluator") {
        //         return redirect()->route('dashboard.index');
        //     }
        // }

        $categories = Category::whereHas('questions.options')->get();
        $categories->each(function ($category) {
            $category->questions->each(function ($question) {
                $question->options = $question->options->shuffle();
            });
        });
        return view('livewire.pages.survey.test', compact('categories'));
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
        $questions = Question::whereIn('id', $options->pluck('question_id'))->get();

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
                $totalPoints += $selectedOption->points;
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

                $questionResult = new QuestionResult([
                    'question_id' => $question->id,
                    'option_id' => $selectedOptionId,
                    'points' => $selectedOption->points,
                ]);

                $questionResult->categoryResult()->associate($categoryResult);
                $questionResult->save();
            }
        }

        if ($request->aksi == "simpan") {
            return redirect()->route('survey.edit',  $result->id);
        }
        return view('survey.waiting');
    }

    // public function update(Request $request, $result)
    // {
    //     //dd($request);
    //     $resultData = Result::find($result);
    //     if ($resultData->user_id != auth()->id()) {
    //         abort(403, 'Unauthorized action.');
    //     }

    //     // Dapatkan opsi terpilih dari request
    //     $selectedOptions = $request->input('questions');
    //     $options = Option::find(array_values($request->input('questions')));

    //     // Temukan pertanyaan yang terkait dengan opsi yang dipilih
    //     $questions = Question::whereIn('id', $options->pluck('question_id'))->get();

    //     // Mengelompokkan pertanyaan berdasarkan kategori soal
    //     $questionsByCategory = $questions->groupBy('category_id');

    //     // Mulai transaksi database
    //     DB::beginTransaction();

    //     try {
    //         //++++++++++++++++++++++++
    //         // Perbarui total_points pada tabel hasil ujian
    //         $totalPoints = Option::whereIn('id', array_values($selectedOptions))->sum('points');
    //         $resultData->update(['total_points' => $totalPoints]);
    //         $resultData->update(['status' => $request->aksi]);

    //         foreach ($questionsByCategory as $categoryId => $categoryQuestions) {
    //             $totalPoint = 0;
    //             $number = 0;

    //             foreach ($categoryQuestions as $question) {
    //                 $selectedOptionId = $selectedOptions[$question->id];
    //                 $selectedOption = Option::find($selectedOptionId);
    //                 $totalPoint += $selectedOption->points;
    //                 $number += 1;
    //             }

    //             $rawfeedback = Range::where('categori_id', $categoryId)
    //                 ->where('min', '<=', $totalPoint)
    //                 ->where('max', '>=', $totalPoint)
    //                 ->first();

    //             // Temukan atau buat kategori hasil ujian yang sudah ada
    //             $categoryResult = CategoryResult::where('result_id', $result)
    //                 ->where('category_id', $categoryId)
    //                 ->first();


    //             if ($categoryResult) {
    //                 // Jika $categoryResult adalah objek yang valid
    //                 if ($categoryResult->attachment) {
    //                     // Jika attachment ada dan tidak null
    //                     $attachmentPath = $categoryResult->attachment;
    //                 } else {
    //                     // Jika attachment null atau kosong
    //                     $attachmentPath = 'File attachment tidak diunggah.';
    //                 }
    //             } else {
    //                 // Jika $categoryResult null atau bukan objek yang valid
    //                 $attachmentPath = 'Data kategori hasil tidak valid.';
    //             }

    //             if ($request->hasFile('attachment')) {
    //                 $attachments = $request->file('attachment');

    //                 if (array_key_exists($categoryId, $attachments)) {
    //                     $attachment = $attachments[$categoryId];
    //                     if ($categoryResult && $categoryResult->attachment) {
    //                         // Hapus file lama jika ada
    //                         Storage::delete($categoryResult->attachment);
    //                     }

    //                     // Simpan file baru dan dapatkan pathnya
    //                     $attachmentPath = $attachment->store('uploads', 'public');
    //                 }
    //             } else {
    //                 // Gunakan nilai attachment dari $categoryResult jika tidak ada file yang diunggah
    //                 $attachmentPath = $categoryResult ? $categoryResult->attachment : null;
    //             }
    //             // Mengganti perbandingan ini dengan jumlah pertanyaan sebenarnya dalam kategori
    //             $jumlahPertanyaan = Question::where('category_id', $categoryId)->count();

    //             if ($number === $jumlahPertanyaan && $attachmentPath != 'File attachment tidak diunggah.') {
    //                 $feedback = $rawfeedback;
    //             } else {
    //                 $feedback = Range::find(1);
    //             }


    //             // Perbarui kategori hasil tes
    //             if ($categoryResult) {
    //                 $categoryResult->update(['total_points' => $totalPoint, 'attachment' => $attachmentPath,]);
    //                 $categoryResult->feedback()->associate($feedback);
    //                 $categoryResult->save();
    //             } else {
    //                 $categoryResult = new CategoryResult([
    //                     'total_points' => $totalPoints,
    //                     'attachment' => $attachmentPath,
    //                 ]);
    //                 $categoryResult->result()->associate($result);
    //                 $categoryResult->feedback()->associate($feedback);
    //                 $categoryResult->category()->associate($categoryId);
    //                 $categoryResult->save();
    //             }

    //             foreach ($categoryQuestions as $question) {
    //                 $selectedOptionId = $selectedOptions[$question->id];
    //                 $selectedOption = Option::find($selectedOptionId);

    //                 // Temukan atau buat hasil pertanyaan yang sudah ada
    //                 $questionResult = QuestionResult::updateOrCreate(
    //                     ['category_result_id' => $categoryResult->id, 'question_id' => $question->id],
    //                     ['option_id' => $selectedOptionId, 'points' => $selectedOption->points]
    //                 );

    //                 // Perbarui hasil pertanyaan
    //                 $questionResult->update(['option_id' => $selectedOptionId, 'points' => $selectedOption->points]);
    //             }
    //         }

    //         // Commit transaksi jika berhasil
    //         DB::commit();

    //         if ($request->aksi == "simpan") {
    //             return redirect()->route('client.test.edit', $result);
    //         }
    //         if ($request->aksi == "kirim") {
    //             return view('client.waiting');
    //         }

    //         //++++++++++++++++++++++++
    //     } catch (\Exception $e) {
    //         // Rollback transaksi jika terjadi kesalahan
    //         DB::rollback();

    //         // Redirect pengguna ke halaman yang sesuai dengan kesalahan yang terjadi
    //         return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi nanti.']);
    //     }
    // }
}
