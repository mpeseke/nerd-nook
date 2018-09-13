// import {Component, OnInit} from "@angular/core";
// import {CheckIn} from "../shared/interfaces/checkIn";
// import {ActivatedRoute} from "@angular/router";
// import {Event} from "../shared/interfaces/event";
// import {Profile} from "../shared/interfaces/profile";
// import {Status} from "../shared/interfaces/status";
// import {CheckInService} from "../shared/services/checkIn.service";
// import {JwtHelperService} from "@auth0/angular-jwt";
// import {ProfileService} from "../shared/services/profile.service";
// import {EventService} from "../shared/services/event.service";
//
//
// //Declare $ for use of jQuery
// // declare let $: any;
//
// @Component({
// 	template: require("./checkIn.component.html"),
// 	selector: "checkIn"
// })
//
// export class CheckInComponent implements OnInit {
//
// 	checkIn: CheckIn;
// 	event: Event = {
// 		eventId: null,
// 		eventCategoryId: null,
// 		eventProfileId: null,
// 		eventDetails: null,
// 		eventEndDateTime: null,
// 		eventLat: null,
// 		eventLong: null,
// 		eventName:null,
// 		eventStartDateTime: null
// 	};
// 	eventId = this.route.snapshot.params["eventId"];
// 	profile: Profile;
// 	status: Status;
//
//
// 	constructor(protected checkInService: CheckInService, protected eventService: EventService, protected route: ActivatedRoute, private profileService: ProfileService, private jwtHelper: JwtHelperService) {
//
// 	}
//
// 	ngOnInit(): void {
// 		this.currentlySignedIn();
// 	}
//
//
//
//
//
// 	checkIntoEvent(): void {
// 		this.checkInService.editCheckIn(this.eventId)
// 			.subscribe(status => {
// 				this.status = status;
//
// 				if(this.status.status === 200) {
// 					alert(status.message);
// 				}
// 		});
// 	}
// }