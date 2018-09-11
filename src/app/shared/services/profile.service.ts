import {Injectable} from "@angular/core";

import {Profile} from "../interfaces/profile";
import {Status} from "../interfaces/status";
import {Observable} from "rxjs";
import {HttpClient, HttpParams} from "@angular/common/http";
import {P} from "@angular/core/src/render3";

@Injectable()
export class ProfileService {

	constructor(protected http: HttpClient) {

	}

	//define the API endpoint
	private profileUrl = "api/profile/";

	//reach out to the profile API and delete the profile in question
	deleteProfile(id : string) : Observable<Status> {
		return(this.http.delete<Status>(this.profileUrl + id));
	}

	//call to the profile API and edit the profile in question
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.profileUrl , profile));
	}

	//call to the profile API and get Profile object by its id
	getProfile(id: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + id));
	}

	//call to the profile API to grab a specific profile based on user input
	getProfileByProfileAtHandle(profileAtHandle: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl, {params: new HttpParams().set("profileAtHandle", profileAtHandle)}));
	}

	//call to the profile API to grab corresponding profile by its email
	getProfileByProfileEmail(profileEmail: string) :Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.profileUrl, {params: new HttpParams().set( "profileEmail", profileEmail)}));
	}

	//call to the profile API to grab a corresponding profile by its id
	getProfileByProfileId(profileId: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + profileId));
	}
}
