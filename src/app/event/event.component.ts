import {Component, OnInit} from "@angular/core";
import {Event} from "../shared/interfaces/event";
import {ActivatedRoute} from "@angular/router";
import {Profile} from "../shared/interfaces/profile";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {AuthService} from "../shared/services/auth.service";


@Component({
	template: require("./event.component.html"),
	selector: "event"
})

export class EventComponent implements OnInit {

	event: Event = {eventId: null, eventCategoryId: null, eventProfileId: null, eventDetails: null,
		eventEndDateTime: null, eventLat: null, eventLong: null, eventName:null, eventStartDateTime: null};
	profile: Profile = {profileId: null, profileActivationToken: null, profileAtHandle: null, profileEmail: null, profileHash: null};
	status: Status;

	constructor(protected eventService: EventService, protected route: ActivatedRoute, private authService: AuthService){

	}
	eventId = this.route.snapshot.params["eventId"];
	ngOnInit() {
		window.sessionStorage.setItem('url', window.location.pathname);
		this.loadEvent();
		this.profile = this.getJwtProfileId();
	}

	loadEvent() {
		this.eventService.getEvent(this.eventId).subscribe(reply => {
			this.event = reply;
		});
	}

	getJwtProfileId(): any {
		if(this.authService.loggedIn()) {
			return this.authService.decodeJwt().auth.profileId;
		} else {
			return false;
		}
	}



}