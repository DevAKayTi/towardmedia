<?php

use App\Enums\PostType;
use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('slug')->nullable(false);
            $table->integer('type_id');
            $table->timestamps();
        });
        $categoryOfArticles = ['Poems', 'Articles', 'Essays', 'Break Free', 'Student Voice', 'Short Novel'];
        $categoryOfNews = ['Student News', 'People Message', 'War News', 'Weekly News', 'Brutal News of Military', 'Politic News', 'CDM News', 'Nway Oo Diary'];
        foreach ($categoryOfArticles as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'type_id' => PostType::Article,
            ]);
        }
        foreach ($categoryOfNews as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'type_id' => PostType::News,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
