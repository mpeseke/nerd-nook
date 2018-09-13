import {Component, OnInit} from "@angular/core";
import {EventService} from "../shared/services/event.service";
import { Status } from "../shared/interfaces/status";
import { Event } from "../shared/interfaces/event";
import {ActivatedRoute, Router} from "@angular/router";


@Component ({
	template: require("./event.list.component.html")
})

export class EventListComponent implements OnInit {

	events: Event[] = [];

	event: Event = {eventId: null, eventCategoryId: null, eventProfileId: null, eventDetails: null,
		eventEndDateTime: null, eventLat: null, eventLong: null, eventName:null, eventStartDateTime: null};


	constructor(protected eventService: EventService, protected  router: ActivatedRoute, protected route : Router) {

	}

	eventId = this.router.snapshot.params["eventId"];

	ngOnInit() {
		//window.sessionStorage.setItem('url', window.location.href);
		this.loadEvents();
	}

	loadEvents() {
		this.eventService.getEventbyDates()
			.subscribe(events => this.events = events);
	}

	changeEvent(event : Event) {
		this.route.navigate(["/event/" + event.eventId])
	}
}