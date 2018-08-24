// import needed @angularDependencies
import {RouterModule, Routes} from "@angular/router";

//import all needed Interceptors
import {SplashComponent} from "./components/splash.component";
import {UserService} from "./services/user.service";
import {APP_BASE_HREF} from "@angular/common";

//import all components
import {SplashComponent} from "./components/splash.component";
import {EventAttendaceComponent} from "./components/event.attendance.component";
import {EditEvent} from "./components/edit.event.component";
import {EditProfile} from "./components/edit.profile.component";
import {EditCommentComponent} from "./components/edit.comment.component"
import {HomeComponent} from "./components/home.component";
import {LandingPageComponent} from "./components/landing.page.component";
import {NavbarComponent} from "./components/main.nav.component";
import {LoginNavComponent} from "./components/login.nav.component";
import {EventComponent} from "./components/event.component";
import {ProfileComponent} from "./components/profile.component";
import {CommentComponent} from "./components/comment.component";
import {CategoryComponent} from "./components/category.component";
import {CheckInCategory} from "./components/";
import {EditCheckInComponent} from "./components/";
import {SignInComponent} from "./components/";
import {SignUpComponent} from "./components/";
import {SignOutComponent} from "./components/"
import {FileSelectDirective} from "./components/"
import {SearchUsersComponent} from "./components/"





//an array of the components that will be passed off the the module
export const allAppComponents = [
	SplashComponent,
	EventAttendanceComponent,
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
	{path: "", component: SplashComponent}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	UserService
];

export const routing = RouterModule.forRoot(routes);