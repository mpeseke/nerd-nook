import {Component, OnInit} from "@angular/core";
import {User} from "../shared/interfaces/user";
import {UserService} from "../shared/services/user.service";

@Component({
	template: require("./splash.template.html")
})

export class SplashComponent implements OnInit {
	users: User[] = [];

	constructor(private userService: UserService) {}

	ngOnInit(): void {
		this.userService.getAllUsers()
			.subscribe(users => this.users = users);
	}
}