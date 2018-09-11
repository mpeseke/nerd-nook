import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import {BrowserModule} from "@angular/platform-browser";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";
import {JwtModule} from "@auth0/angular-jwt";
import { NguiMapModule} from '@ngui/map';

const moduleDeclarations = [AppComponent];

//configure the parameters for the JwtModule
const JwtHelper = JwtModule.forRoot({
		config: {
					tokenGetter: () => {
								return localStorage.getItem("jwt-token");
					},
					skipWhenExpired:true,
					whitelistedDomains: ["localhost:7272", "https://bootcamp-coders.cnm.edu/"],
					headerName:"X-JWT-TOKEN",
					authScheme: ""
		}
});



@NgModule({
	imports:      [BrowserModule, HttpClientModule, JwtHelper, routing, FormsModule, ReactiveFormsModule, NguiMapModule.forRoot({apiUrl: 'https://maps.google.com/maps/api/js?key=AIzaSyCoNb2WQ7czV7rzbh90yRQ4TqhWkWcm4Uk'})],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})
export class AppModule {}