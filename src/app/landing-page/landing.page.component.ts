import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {ActivatedRoute, Router} from "@angular/router";
import {JwtHelperService} from "@auth0/angular-jwt";
import {AuthService} from "../shared/services/auth.service";

@Component ({
	template: require("./landing.page.component.html")
})

export class LandingPageComponent implements OnInit {

	profileId: string = this.route.snapshot.params["id"];

	authAtHandle: string = null;


	profile: Profile = {
		profileActivationToken: null,
		profileAtHandle: null,
		profileEmail: null,
		profileHash: null,
		profileId: null,
	};

	constructor(private profileService: ProfileService, private route: ActivatedRoute, private jwtHelper: JwtHelperService, private authService: AuthService, private router: Router) {
	}

	ngOnInit(): void {
		this.currentlySignedIn();
		//this.getProfile();
		this.authAtHandle = this.authService.decodeJwt().auth.profileAtHandle;

	}

	currentlySignedIn(): void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));
	}


	profilePageRedirect(): void {
		this.router.navigate(["/profile/", this.authAtHandle]);
	}
}
// 	getProfile() {
// 		this.profileService.getProfileByProfileId(this.tempId)
// 			.subscribe(profile => this.profile = profile);
//
// 	}
//
