import {Component, OnInit} from "@angular/core";
import {EventService} from "../shared/services/event.service";
import {Status} from "../shared/interfaces/status";
import { Event } from "../shared/interfaces/event";
import {ActivatedRoute, Router} from "@angular/router";


@Component ({
	template: require("./event.list.component.html")
})

export class EventListComponent implements OnInit{
	event: Event;

	constructor (protected eventService: EventService, protected  router: ActivatedRoute) {

	}
	eventId = this.router.snapshot.params["eventId"];
	ngOnInit() {
		window.sessionStorage.setItem('url', window.location.href);
		this.loadEvent();
	}

	loadEvent() {
		this.eventService.getEvent(this.eventId).subscribe(reply => {
			this.event = reply;
		});
	}
}