import {Injectable} from "@angular/core";

import {Event} from "../interfaces/event";
import {Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class EventService {

	constructor(protected http: HttpClient) {}

	//define the API endpoint

	private eventUrl = "api/event/";

	
}