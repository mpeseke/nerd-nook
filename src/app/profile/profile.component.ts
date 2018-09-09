import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {ActivatedRoute} from "@angular/router";
import {JwtHelperService} from "@auth0/angular-jwt";


@Component({
		template: require("./profile.component.html")
})

	export class ProfileComponent implements OnInit{

	profile: Profile = new class implements Profile {
		profileActivationToken: number = null;
		profileAtHandle: string = null;
		profileEmail: string = null;
		profileHash: string = null;
		profileId: string = null;
	};

	profileId : string = this.route.snapshot.params["id"];

	constructor(private profileService: ProfileService, private route: ActivatedRoute, private jwtHelper : JwtHelperService) {}

	ngOnInit(): void {
		this.currentlySignedIn();
		this.getProfile()
	}

	currentlySignedIn() : void {

		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));

		this.profileService.getProfile(decodedJwt.auth.profileId)
			.subscribe(profile => this.profile = profile)

	}

	getProfile() {
		this.profileService.getProfile(this.profileId)
			.subscribe(profile => this.profile = profile);

	}

}
