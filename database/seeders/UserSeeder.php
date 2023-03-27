<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 */
	public function run(): void{
		//
		User::truncate();
		User::create([
			'name' => 'mohamed nasser',
			'email' => 'mohamed@mail.com',
			'password' => hash::make('12345689'),
		]);

		User::create([
			'name' => 'ahmed gmal',
			'email' => 'ahmed@mail.com',
			'password' => hash::make('12345689'),
		]);

		User::create([
			'name' => 'Nour Ameen',
			'email' => 'nour@mail.com',
			'password' => hash::make('12345689'),
		]);

		User::create([
			'name' => 'osama sayed',
			'email' => 'osama@mail.com',
			'password' => hash::make('12345689'),
		]);

		User::create([
			'name' => 'ibrahim gamal',
			'email' => 'ibrahim@mail.com',
			'password' => hash::make('12345689'),
		]);

	}
}
