import {Injectable} from "@angular/core";

import {Event} from "../interfaces/event";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {HttpClient, HttpParams} from "@angular/common/http";

@Injectable()
export class EventService {

	constructor(protected http: HttpClient) {}

	//define the API endpoint

	private eventUrl = "api/event/";

	// call to the Event API to edit a specific Event

	editEvent(event : Event) : Observable<Status> {
		return(this.http.put<Status>(this.eventUrl + event.eventId, event));
	}

	//call to the Event API to create a dope freaking Event

	createEvent(event : Event) : Observable<Status> {
		return(this.http.post<Status>(this.eventUrl, event));
	}

	//call to the Event API to grab an Event object based on it's ID

	getEvent(eventId : number) : Observable<Event> {
		return(this.http.get<Event>(this.eventUrl + eventId));
	}


	//call to the Event API to grab an array of events based on their Category Id

	getEventbyCategoryId(eventCategoryId : string) : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl,{params: new HttpParams().set("eventCategoryId", eventCategoryId)}));
	}

	//call to event API and get an array of events based on their Profile Id

	getEventbyProfileId(eventProfileId : string) : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl, {params: new HttpParams().set("eventProfileId", eventProfileId)}));
	}

	//call to the API to get an array of events within a specific date range

	getEventbyDates() : Observable<Event[]> {
		return(this.http.get<Event[]>(this.eventUrl));
	}
}