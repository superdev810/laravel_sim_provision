<?php
namespace App\Providers;

use Form;
use Illuminate\Support\ServiceProvider;



class CustomFormComponentsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsText', 'component.form.text', ['name', 'value', 'attributes','label']);
        Form::component('bsPassword', 'component.form.password', ['name', 'value', 'attributes','label']);
        Form::component('bsSelect', 'component.form.select', ['name', 'value', 'attributes', 'label','selected']);
        Form::component('bsRadio', 'component.form.radio', ['name', 'value', 'attributes', 'label', 'selected']);
        Form::component('bsTextArea', 'component.form.text-area', ['name', 'value', 'attributes', 'label', 'selected']);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
