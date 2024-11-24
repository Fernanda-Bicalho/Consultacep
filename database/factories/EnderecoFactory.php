<?php

namespace Database\Factories;

use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => $this->faker->postcode(),  
            'rua' => $this->faker->streetName(),  
            'bairro' => $this->faker->word(),  
            'cidade' => $this->faker->city(), 
            'uf' => $this->faker->stateAbbr(),  
            'numero' => $this->faker->buildingNumber(),  
            'ibge' => $this->faker->randomNumber(6, true),  
        ];
    }
}

