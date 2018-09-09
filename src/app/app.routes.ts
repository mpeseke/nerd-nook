// import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

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
import {EventComponent} from "./event/event.component";
import {ProfileComponent} from "./profile/profile.component";
import {LandingPageComponent} from "./landing-page/landing.page.component";
import {SignInComponent} from "./shared/components/sign.in.component";
import {CategoryComponent} from "./category/category.component";
import {EventListComponent} from "./event-list/event.list.component";
import {AddEventComponent} from "./add-event/add.event.component";
import {CheckInComponent} from "./checkIn/checkIn.component";

// an array of the components that will be passed off the the module
export const allAppComponents = [
	SplashComponent,
	CategoryComponent,
	AddEventComponent,
	EventComponent,
	EventListComponent,
	LandingPageComponent,
	ProfileComponent,
	SignInComponent,
	CheckInComponent
];

export const routes: Routes = [
	{path: "signin", component: SignInComponent},
	{path: "profile", component: ProfileComponent},
	{path: "add-event", component: AddEventComponent},
	{path: "event", component: EventComponent},
	{path: "event-list", component: EventListComponent},
	{path: "category", component: CategoryComponent},
	{path: "landing-page", component: LandingPageComponent},
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