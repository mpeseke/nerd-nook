import {Component, OnInit} from "@angular/core";
import {Event} from "../shared/interfaces/event";
import {ActivatedRoute} from "@angular/router";
import {Profile} from "../shared/interfaces/profile";
import {CheckIn} from "../shared/interfaces/checkIn";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {AuthService} from "../shared/services/auth.service";
import {CheckInService} from "../shared/services/checkIn.service";
import {ProfileService} from "../shared/services/profile.service";
import {JwtHelperService} from "@auth0/angular-jwt";

@Component({
	template: require("./event.component.html"),
	selector: "event"
})
export class EventComponent implements OnInit {
	event: Event = {
		eventId: null,
		eventCategoryId: null,
		eventProfileId: null,
		eventDetails: null,
		eventEndDateTime: null,
		eventLat: null,
		eventLong: null,
		eventName: null,
		eventStartDateTime: null
	};
	profile: Profile = {
		profileId: null,
		profileActivationToken: null,
		profileAtHandle: null,
		profileEmail: null,
		profileHash: null
	};
	status: Status;
	checkIn: CheckIn;
	constructor(protected eventService: EventService, protected checkInService: CheckInService, private profileService: ProfileService, private jwtHelper: JwtHelperService, protected route: ActivatedRoute, private authService: AuthService) {
	}
	eventId = this.route.snapshot.params["eventId"];
	ngOnInit() {
		window.sessionStorage.setItem('url', window.location.pathname);
		this.loadEvent();
		this.currentlySignedIn();
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
	currentlySignedIn(): void {
		const decodedJwt = this.jwtHelper.decodeToken(localStorage.getItem('jwt-token'));
		this.profileService.getProfile(decodedJwt.auth.profileId).subscribe(profile => this.profile = profile)
	}
	rsvp(): void {
		this.checkInService.createCheckIn(this.eventId)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					alert(status.message);
				}
			});
	}
	checkIntoEvent(): void {
		this.checkInService.editCheckIn(this.eventId)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					alert(status.message);
				}
			});
	}
}