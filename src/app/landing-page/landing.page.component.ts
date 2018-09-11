import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/interfaces/profile";
import {ActivatedRoute} from "@angular/router";
import {JwtHelperService} from "@auth0/angular-jwt";

@Component ({
	template: require("./landing.page.component.html")
})

export class LandingPageComponent implements OnInit{

	profile : Profile =  {
		profileActivationToken: null,
		profileAtHandle: null,
		profileEmail: null,
		profileHash: null,
		profileId: null,
};


profileId : string = this.route.snapshot.params["id"];

	constructor(private profileService: ProfileService, private route: ActivatedRoute, private jwtHelper : JwtHelperService) {}

	ngOnInit(): void {
	this.currentlySignedIn();
	this.getProfile()
	}

	currentlySignedIn() : void {

	const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));
}

	getProfile() {
		this.profileService.getProfileByProfileId(this.profileId)
			.subscribe(profile => this.profile = profile);

	}

}