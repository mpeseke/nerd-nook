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
		this.eventService.getEvent(this.eventId).subscribe(event => this.event = event);
	}


}