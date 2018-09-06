// import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";
import {AuthGuardService as AuthGuard} from "./shared/services/auth.guard.service";

//import all needed Interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";




//import all services
import {AuthService} from "./shared/services/auth.service";
import {AuthGuardService} from "./shared/services/auth.guard.service";
import {CookieService} from "ng2-cookies";
import {JwtHelperService} from"@auth0/angular-jwt";
import {EventService} from "./shared/services/event.service";
import {ProfileService} from "./shared/services/profile.service";
import {CategoryService} from "./shared/services/category.service";
import {CommentService} from "./shared/services/comment.service";
import {CheckInService} from "./shared/services/checkIn.service";
import {SignInService} from "./shared/services/sign.in.service";
import {SignUpService} from "./shared/services/sign.up.service";
import {SessionService} from "./shared/services/session.service";
import {SplashComponent} from "./splash/splash.component";


// an array of the components that will be passed off the the module
export const allAppComponents = [
	SplashComponent
];

export const routes: Routes = [
	{path: "", component: SplashComponent},

];

// an array of services that will be passed off to the module
const services : any[] = [AuthService,CookieService,JwtHelperService,EventService,ProfileService,CommentService,CheckInService,CategoryService,SessionService,SignInService,SignUpService,AuthGuardService];

//an array of misc provider
export const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);