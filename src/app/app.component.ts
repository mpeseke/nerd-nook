import {Component, OnInit} from "@angular/core";
import {Status} from "./shared/interfaces/status";
import {SessionService} from "./shared/services/session.service";
import {SignInService} from "./shared/services/sign.in.service";
import {Profile} from "./shared/interfaces/profile";
import {AuthService} from "./shared/services/auth.service";
import {Router} from "@angular/router";
import {ActivatedRoute} from "@angular/router";

@Component({
	selector: "nerd-nook-app",
	template: require("./app.component.html"),
})

export class AppComponent implements OnInit{
	status : Status = null;

	profileId: string = this.route.snapshot.params["id"];

	authAtHandle: string = null;


	profile: Profile = {
		profileActivationToken: null,
		profileAtHandle: null,
		profileEmail: null,
		profileHash: null,
		profileId: null,
	};


	constructor(protected sessionService : SessionService, private signInService : SignInService, private authService: AuthService, private router: Router, private route: ActivatedRoute) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}

	signOut() : void {
		localStorage.clear();
		this.signInService.signOut().subscribe(status=>this.status=status);
		window.location.replace("/signin");
	}

	ngOnInit(): void {
		//this.getProfile();
		this.authAtHandle = this.authService.decodeJwt().auth.profileAtHandle;

	}

	profilePageRedirect(): void {
		this.router.navigate(["/profile/", this.authAtHandle]);
	}
}