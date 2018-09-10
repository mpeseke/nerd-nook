import {Component, OnInit, ViewChild} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {Event} from "../shared/interfaces/event";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {CategoryComponent} from "../category/category.component";


@Component ({
	template: require("./add.event.component.html")
})

export class AddEventComponent implements OnInit{

	createEventForm: FormGroup;
	events: Event[] = [];
	@ViewChild(CategoryComponent) categoryComponent: CategoryComponent;
	status: Status = null;

	constructor(private formBuilder: FormBuilder, private eventService: EventService, private router: Router) {
		console.log("Event added successfully!")
	}


	ngOnInit() : void {
		this.createEventForm = this.formBuilder.group({
			eventCategoryId: ["", [Validators.required]],
			eventDetails: ["", [Validators.maxLength(512), Validators.required]],
			eventStartDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventEndDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventLocation: ["", [Validators.maxLength(255), Validators.required]]
		});
	}

	createEvent() {
	let event: Event = {eventId: null, eventCategoryId: this.createEventForm.value.categoryId , eventProfileId: null,
		eventDetails: this.createEventForm.value.eventDetails, eventEndDateTime: this.createEventForm.value.eventEndDateTime,
		eventLat: this.createEventForm.value.eventLocation, eventLong: this.createEventForm.value.eventLocation,
		eventStartDateTime: this.createEventForm.value. eventStartDateTime};
	this.eventService.createEvent(event).subscribe(status =>{
		this.status = status;
		if(status.status === 200) {
			this.router.navigate(["/event-list"]);
		}
	});
	}
}