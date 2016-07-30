<?php

namespace BoojBit;

use Illuminate\Support\ServiceProvider;
use Illuminate\Facades\App;

class BoojBitServiceProvider extends ServiceProvider
{

	public $packageName = 'boojBit';

	public function register()
	{
		$this->manageConfigs();

		$this->registerFacades();
	}

	public function boot()
	{
		$this->loadViewsFrom(__DIR__.'/resources/views', $this->packagesName);
		include __DIR__.'helpers.php';
		include __DIR__.'bladeHelpers.php';
		$this->publishes([__DIR__.'/config.php' => base_path('config)], $this->packageName.':configs');
		$this->publishes([__DIR__.'/database/migrations' => base_path('database/migrations')], $this->packageName.':migrations');
		$this->publishes([__DIR__.'/database/seeds' => base_path('database/seeds')], $this->packageName.':seeds');
		$this->publishes([__DIR__.'/resources/views' => base_path('resources/views/vendor/')], $this->packageName.':views');
	}

	public function manageConfigs()
	{
		$fileSystem = new Filesystem();
		$files = $fileSystem->files(__DIR__.'/config');
		if (!empty($files)) {
			foreach ($files as $file) {
				$name = explode('/', $file);
				$this->mergeConfigFrom($file, str_replace('.php', '', $name[count($name) - 1]));
			}
		}
	}

	public function provides()
	{
		return [
			'BoojBit\Controllers\BoojBitController',
		];
	}

}
