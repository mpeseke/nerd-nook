import { Component, OnInit } from "@angular/core";
import { CheckIn } from "../shared/interfaces/checkIn";
import { ActivatedRoute } from "@angular/router";
import { Event } from "../shared/interfaces/event";
import { Profile } from "../shared/interfaces/profile";
import { Status } from "../shared/interfaces/status";
import { CheckInService } from "../shared/services/checkIn.service";
import { JwtHelperService } from "@auth0/angular-jwt";
import { ProfileService } from "../shared/services/profile.service";

@Component({
	template: require("./checkIn.component.html"),
	selector: "checkIn"
})

export class CheckInComponent implements OnInit{

	checkIn: CheckIn;
	event: Event;
	profile: Profile;
	eventId=this.route.snapshot.params["eventId"];
	status: Status;

	constructor(protected checkInService: CheckInService, protected route: ActivatedRoute, private profileService: ProfileService, private jwtHelper : JwtHelperService ){

	}

	ngOnInit() : void {
		this.currentlySignedIn()
	}
	currentlySignedIn() : void {
		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));
		this.profileService.getProfile(decodedJwt.auth.profileId).subscribe(profile => this.profile = profile)
	}

	rsvp(){
		this.checkInService.createCheckIn(this.eventId).subscribe(status => {this.status=status});
	}

	checkIntoEvent(){
		this.checkInService.editCheckIn(this.eventId).subscribe(status => {this.status=status});
	}
}