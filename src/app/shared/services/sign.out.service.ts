import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/common/http";
import {Observable} from "rxjs";
import {Status} from "../interfaces/status";

@Injectable()
export class SignOutService {

	constructor(protected http: HttpClient) {
	}

	private signOutUrl = "api/sign-out";

	getSignOut(): Observable<Status> {
		return (this.http.get<Status>(this.signOutUrl));
	}
}
