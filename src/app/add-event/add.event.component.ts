import {Component, OnInit, ViewChild} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {Event} from "../shared/interfaces/event";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {CategoryComponent} from "../category/category.component";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/interfaces/category";
import { DatePipe } from "@angular/common";
import {getTime} from 'date-fns';


@Component ({
	template: require("./add.event.component.html")
})

export class AddEventComponent implements OnInit{

	createEventForm: FormGroup;
	events: Event[] = [];
	@ViewChild(CategoryComponent) categoryComponent: CategoryComponent;
	status: Status = null;
	categories: Category[] =[];

	constructor(private formBuilder: FormBuilder, private eventService: EventService, private router: Router, private categoryService: CategoryService) {

	}


	ngOnInit() : void {
		this.createEventForm = this.formBuilder.group({
			eventCategoryId: ["", [Validators.required]],
			eventDetails: ["", [Validators.maxLength(512), Validators.required]],
			eventStartDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventEndDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventLocation: ["", [Validators.maxLength(255), Validators.required]]
		});
		this.categoryService.getAllCategories().subscribe(categories=>this.categories=categories);
	}

	createEvent() {
		console.log(this.createEventForm.value);

		let endDateTime = getTime(this.createEventForm.value.eventEndDateTime);
		let startDateTime = getTime(this.createEventForm.value.eventStartDateTime);
	let event: Event = {eventId: null, eventCategoryId: this.createEventForm.value.eventCategoryId, eventProfileId: null,
		eventDetails: this.createEventForm.value.eventDetails, eventEndDateTime: endDateTime ,
		eventLat: this.createEventForm.value.eventLocation, eventLong: this.createEventForm.value.eventLocation,
		eventStartDateTime: startDateTime};

	console.log(event);
	this.eventService.createEvent(event).subscribe(status =>{
		this.status = status;
		if(status.status === 200) {
			this.router.navigate(["/event-list"]);
		}
	});
	}
}