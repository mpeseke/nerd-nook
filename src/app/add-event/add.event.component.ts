import {Component, OnInit, ViewChild} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Router} from "@angular/router";
import {Event} from "../shared/interfaces/event";
import {Status} from "../shared/interfaces/status";
import {EventService} from "../shared/services/event.service";
import {CategoryComponent} from "../category/category.component";
import {CategoryService} from "../shared/services/category.service";
import {Category} from "../shared/interfaces/category";
import { getTime } from 'date-fns';
import { GeoCoder } from "@ngui/map";


@Component ({
	template: require("./add.event.component.html")
})

export class AddEventComponent implements OnInit{

	createEventForm: FormGroup;
	events: Event[] = [];
	@ViewChild(CategoryComponent) categoryComponent: CategoryComponent;
	status: Status = null;
	categories: Category[] =[];
	returnObject = {lat: null, lng: null};

	constructor(private formBuilder: FormBuilder, private eventService: EventService, private router: Router, private categoryService: CategoryService, protected geoCoder: GeoCoder) {

	}


	ngOnInit() : void {
		this.createEventForm = this.formBuilder.group({
			eventCategoryId: ["", [Validators.required]],
			eventName: ["", [Validators.maxLength(36), Validators.required]],
			eventDetails: ["", [Validators.maxLength(512), Validators.required]],
			eventStartDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventEndDateTime: ["", [Validators.maxLength(6), Validators.required]],
			eventStreet: ["", [Validators.maxLength(255), Validators.required]],
			eventStreet2: ["", [Validators.maxLength(255)]],
			eventCity: ["", [Validators.maxLength(255), Validators.required]],
			eventState: ["", [Validators.maxLength(2), Validators.required]],
			eventZip: ["", [Validators.maxLength(10), Validators.required]],
		});
		this.categoryService.getAllCategories().subscribe(categories=>this.categories=categories);
	}

	createEvent() {
		console.log(this.createEventForm.value);

		//use the street address for decoding to obtain the lat and long; create the results object required by google
		let results = {address: `${this.createEventForm.value.eventStreet} ${this.createEventForm.value.eventStreet2} ${this.createEventForm.value.eventCity}, ${this.createEventForm.value.eventState} ${this.createEventForm.value.eventZip}`};
		//console.log(results);

		this.geoCoder.geocode(results).subscribe(reply => {
		this.returnObject.lat = reply[0].geometry.bounds.f.b;
		this.returnObject.lng = reply[0].geometry.bounds.b.b;
		});

		console.log(this.returnObject);

		let endDateTime = getTime(this.createEventForm.value.eventEndDateTime);
		let startDateTime = getTime(this.createEventForm.value.eventStartDateTime);
		let event: Event = {eventId: null, eventCategoryId: this.createEventForm.value.eventCategoryId, eventProfileId: null,
		eventName: this.createEventForm.value.eventName, eventDetails: this.createEventForm.value.eventDetails, eventEndDateTime: endDateTime, eventStartDateTime: startDateTime, eventLat: 	this.returnObject.lat, eventLong: this.returnObject.lng};

	console.log(event);
	this.eventService.createEvent(event).subscribe(status =>{
		this.status = status;
		if(status.status === 200) {
			alert("Event created successfully!");
			this.router.navigate(["/event-list"]);
		} else {
			alert("Probably fix what's wrong and then we can talk...");
		}
	});
	}
}