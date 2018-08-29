import {Injectable} from "@angular/core";
import {HttpClient, HttpParams} from "@angular/common/http";
import {Observable} from "rxjs/internal/Observable"
import {Status} from "../interfaces/status";
import {SignIn} from "../interfaces/sign.in";

@Injectable()
export class SignInService {
	private signInUrl = "api/sign-in/";
	private signOutUrl = "api/sign-out/";

	constructor(protected http : HttpClient) {

	}

	//preform the post to initiate sign in
	postSignIn(signIn:SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.signInUrl, signIn));
	}

	signOut() : Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl));
	}
}


