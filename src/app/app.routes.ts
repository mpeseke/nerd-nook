// import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

//import all needed Interceptors
import {SplashComponent} from "./components/splash.component";
import {UserService} from "./shared/services/user.service";
import {APP_BASE_HREF} from "@angular/common";

//import all components
import {SplashComponent} from "./components/splash.component";
import {CreateEventComponent} from "./components/create.event.component";
import {EditEventComponent} from "./components/edit.event.component";
import {EditProfileComponent} from "./components/edit.profile.component";
import {EditCommentComponent} from "./components/edit.comment.component"
import {HomeComponent} from "./components/home.component";
import {LandingPageComponent} from "./components/landing.page.component";
import {NavbarComponent} from "./components/main.nav.component";
import {LoginNavComponent} from "./components/login.nav.component";
import {EventComponent} from "./components/event.component";
import {ProfileComponent} from "./components/profile.component";
import {CommentComponent} from "./components/comment.component";
import {CategoryComponent} from "./components/category.component";
import {CheckInComponent} from "./components/check.in.component";
import {EditCheckInComponent} from "./components/edit.check.in.component";
import {SignInComponent} from "./components/sign.in.component";
import {SignUpComponent} from "./components/sign.up.component";
import {SignOutComponent} from "./components/sign.out.component";
import {FileSelectDirective} from "ng-file-upload";
import {SearchUsersComponent} from "./components/search.users.component";


//import all services
import {AuthService} from "./shared/services/auth.service";
import {AuthGaurdService} from "./shared/services/auth.gaurd.service"
import {CookieService} from "ng2-cookies";
import{JwtHelperService} from"@auth0/angular-jwt";
import {EventService} from "./shared/services/event.service";
import {ProfileService} from "./shared/services/profile.service";
import {CategoryService} from "./shared/services/category.service";
import {CommentService} from "./shared/services/comment.service";
import {CheckInService} from "./shared/services/check.in.service";
import {SignInService} from "./service/sign.in.service";
import {SignUpService} from "./shared/services/sign.up.service";
import {SignOutService} from "./shared/services/sign.out.service";
import {SessionService} from "./shared/services/session.services";
import {HTTP_INTERCEPTORS} from "@angular/common/http";


//an array of the components that will be passed off the the module
export const allAppComponents = [
	SplashComponent,
	CreateEventComponent,
	EditEventComponent,
	EditProfileComponent,
	EditCommentComponent,
	EditCheckInComponent,
	HomeComponent,
	LandingPageComponent,
	LoginNavComponent,
	NavbarComponent,
	EventComponent,
	ProfileComponent,
	CheckInComponent,
	CommentComponent,
	CategoryComponent,
	SignInComponent,
	SignUpComponent,
	SignOutComponent,
	SearchUsersComponent,
	FileSelectDirective,
];

export const routes: Routes = [
	{path: "", component: LandingPageComponent},
	{path: "home", component: HomeComponent},
	{path: "sign-out", component: SignOutComponent},
	{path: "edit-event", component: EditEventComponent, canActivate:[AuthGaurd]},
	{path: "search-users", component: SearchUsersComponent},
	{path: "event/:eventId", component: EventComponent},
	{path: "profile/:id", component: ProfileComponent},
	{path: "comment/:commentId", component: CommentComponent},
];

// an array of services that will be passed off to the module
const services : any[] = [AuthService,CookieService,JwtHelperService,EventService,ProfileService,CommentService,CheckInService,CategoryService,SessionService,SignInService,SignUpService,SignOutService,AuthGaurdService];

//an array of misc provider
export const providers: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);