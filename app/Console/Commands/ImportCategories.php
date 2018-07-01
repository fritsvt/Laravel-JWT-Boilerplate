<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ImportCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import categories in database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $categories = file_get_contents('./data/categories.json');

        //Category::truncate();

        $json = json_decode($categories);
        $verkeersborden = false;

        foreach ($json->result as $key=>$category) {
            $category->sub_cat = null;
            if (str_contains($category->name, "verkeersborden")) {
                if (!$verkeersborden) {
                    Category::create([
                        'name' => "Verkeersborden",
                        'slug' => 'verkeersborden',
                        'sub_cat' => null,
                        'icon' => $category->icon
                    ]);
                }
                $category->sub_cat = 'verkeersborden';
                $verkeersborden = true;
            }
            Category::create([
                'name' => ucfirst(str_replace('-', ' ', $category->name)),
                'slug' => $category->name,
                'sub_cat' => $category->sub_cat,
                'icon' => $category->icon
            ]);
        }

        echo "categories successfully added";

        return;

    }
}
