import { enableProdMode } from '@angular/core';
import { platformBrowserDynamic } from '@angular/platform-browser-dynamic';

import { AppModule } from './app/app.module';


window.addEventListener("DOMContentLoaded", event => {
	if(process.env.ENV === "live") {
		enableProdMode();
	}
	const platform = platformBrowserDynamic();
	platform.bootstrapModule(AppModule);
});