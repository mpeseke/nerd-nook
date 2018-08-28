import{Injectable} from "@angular/core";

import{Status} from "../interfaces/status"
import {CheckIn} from "../interfaces/checkIn";
import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class CheckInService{

	constructor(protected http : HttpClient)
}
