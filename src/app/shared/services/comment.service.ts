import {Injectable} from "@angular/core";

import{Status} from "../interfaces/status";
import {Comment} from "../interfaces/comment"
import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@injectable ()
export class CommentService {
	constructor(protected http : HttpClient ) {

		//define the API end point
	}
}