<?php
use App\Models\Category;
use App\Models\Range;
use App\Models\Result;
use App\Models\Rule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_results', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Result::class)->constrained()->cascadeOnDelete()->nullable();
            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete()->nullable();
            $table->foreignIdFor(Range::class)->constrained()->cascadeOnDelete();
            $table->integer('total_points')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_results');
    }
}
