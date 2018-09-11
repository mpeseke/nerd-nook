import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {ActivatedRoute} from "@angular/router";
import {JwtHelperService} from "@auth0/angular-jwt";


@Component({
		template: require("./profile.component.html")
})

	export class ProfileComponent implements OnInit{

	profile: Profile =  {
		profileActivationToken: null,
		profileAtHandle: null,
		profileEmail: null,
		profileHash: null,
		profileId: null,
	};

	profileAtHandle : string = this.route.snapshot.params["username"];

	constructor(private profileService: ProfileService, private route: ActivatedRoute, private jwtHelper : JwtHelperService) {}

	ngOnInit(): void {
		this.currentlySignedIn();
		this.getProfile()
	}

	currentlySignedIn() : void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));

		this.profileService.getProfileByProfileAtHandle(decodedJwt.auth.profileId)
			.subscribe(profile => this.profile = profile)

	}

	getProfile() {
		this.profileService.getProfileByProfileAtHandle(this.profileAtHandle)
			.subscribe(profile => this.profile = profile);

	}

}
