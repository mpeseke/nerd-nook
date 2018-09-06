import {Component} from "@angular/core";
import {Status} from "../interfaces/status";
import {ProfileService} from "../services/profile.service";

@Component({
	selector:"profile",
	template: require ("./profile.html")
})

export class ProfileComponent {
	status: Status = null;

	constructor(private profileService: ProfileService) {}
	signOut() : void{
		this.profileService.signOut();
	}
}