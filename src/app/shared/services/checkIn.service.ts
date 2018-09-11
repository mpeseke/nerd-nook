import{Injectable} from "@angular/core";

import{Status} from "../interfaces/status"
import {CheckIn} from "../interfaces/checkIn";
import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class CheckInService {

	constructor(protected http : HttpClient) {}

	//define the API endpoint

	private checkInUrl = "api/checkIn/";


	//call to the checkIn API to create a checkIn
	createCheckIn(checkIn : CheckIn) : Observable<Status> {
		return(this.http.post<Status>(this.checkInUrl, checkIn));
	}

	//call to the event
	editCheckIn(checkIn : CheckIn) : Observable<Status> {
		return(this.http.put<Status>(this.checkInUrl, checkIn));
	}
}
