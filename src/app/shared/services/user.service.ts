import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/internal/Observable";
import {User} from "../interfaces/user";

@Injectable()
export class UserService {

	private userUrl = "https://jsonplaceholder.typicode.com/users/";

	constructor(protected http: HttpClient) {}

	getAllUsers(): Observable<User[]> {
		return(this.http.get<User[]>(this.userUrl));
	}
}