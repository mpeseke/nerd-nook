import {Component, OnInit} from "@angular/core";
import {Event} from "../shared/interfaces/event";
import {ActivatedRoute} from "@angular/router";
import {Profile} from "../shared/interfaces/profile";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {CheckInService} from "../shared/services/checkIn.service";
import {ProfileService} from "../shared/services/profile.service";
import {CategoryComponent} from "../category/category.component";

@Component({
	template: require("./event.component.html"),
	selector: "event"
})

export class EventComponent implements OnInit {

	event: Event;
	profile: Profile;
	eventId = this.route.snapshot.params["eventId"];
	status: Status;

	constructor(protected eventService: EventService, protected checkInService: CheckInService, protected route: ActivatedRoute, private profileService: ProfileService){

	}

	ngOnInit(): void {
		this.currentlySignedIn()
	}

	currentlySignedIn(): void {
		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));
		this.profileService.getProfile(decodedJwt.auth.profileId).subscribe(profile => this.profile = profile)
	}

	rsvp() {
		this.checkInService.createCheckIn(this.eventId).subscribe(status => {
			this.status = status;
		});
	}

	checkIntoEvent() {
		this.checkInService.editCheckIn(this.checkInEventId).subscribe(status => {
			this.status = status;
		});
	}
}