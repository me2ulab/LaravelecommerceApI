<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Transaction;
use App\Category;
use App\Product;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0');
    	User::truncate();
    	Product::truncate();
    	Category::truncate();
    	Transaction::truncate();
    	DB::table('category_product')->truncate();
    	$usersQuantity=1000;
    	$productsQuantity=1000;
    	$categoriesQuantity=30;
    	$transactionQuantity=1000;
    	factory(User::class,$usersQuantity)->create();
    	factory(Category::class,$categoriesQuantity)->create();
    	factory(Product::class,$productsQuantity)->create()->each(
    		function($product){
    			$categories=Category::all()->random(mt_rand(1,5))->pluck('id');
    			$product->categories()->attach($categories);
    		}
    	);
    	factory(Transaction::class,$transactionQuantity)->create();


        // $this->call(UsersTableSeeder::class);
    }
}
