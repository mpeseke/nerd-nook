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
import {GeoCoder} from "@ngui/map";

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

	// allOptions = {
	// 	center: {lat: this.event.eventLat, lng: this.event.eventLong},
	// 	zoom: 15
	// };

	constructor(protected eventService: EventService, protected checkInService: CheckInService, private profileService: ProfileService, private jwtHelper: JwtHelperService, protected route: ActivatedRoute, private authService: AuthService, protected geoCoder: GeoCoder) {
	}

	eventId = this.route.snapshot.params["eventId"];
	ngOnInit() {
		window.sessionStorage.setItem('url', window.location.pathname);
		this.loadEvent();
		this.currentlySignedIn();
		this.profile = this.getJwtProfileId();
	}

	// getAddress() {
	// 	let location = [];
	// 	location["lat"] = this.event.eventLat;
	// 	location["lng"] = this.event.eventLong;
	// 	let results = {location: this.event.eventLat + this.event.eventLong};
	//
	// 	let geocodeLocationResponse = null;
	//
	// 	this.geoCoder.geocode(results).subscribe(
	// 		reply => {
	// 			console.log(reply);
	// 			geocodeLocationResponse = reply[0].geometry.location
	//
	// });
	// }

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

	// clicked(event) {
	// 	let marker = event.target;
	// 	console.log(marker);
	//
	// 	marker.nguiMapComp.openInfoWindow('event', marker);
	// }

}

