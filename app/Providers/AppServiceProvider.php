<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('search', function($field, $string){
            return $string ? $this->where($field, 'like', '%'.$string.'%') : $this;
        });
        

        Builder::macro('toCsv', function(){
            $results = $this->get();
        
            if ($results->isEmpty()) {
                return;
            }
        
            $csvData = [];
        
            // Assuming each row in $results is an associative array
            foreach ($results as $row) {
                $csvData[] = implode(',', $row);
            }
        
            $csvContent = implode(PHP_EOL, $csvData);
        
            // Output the CSV data, you might want to customize this based on your needs
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="export.csv"');
            echo $csvContent;
            exit;
        });
        
    }
}
