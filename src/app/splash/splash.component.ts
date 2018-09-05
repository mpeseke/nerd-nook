import {Component, OnInit} from "@angular/core";
import {User} from "../shared/interfaces/user";

@Component({
	template: require("./splash.template.html")
})

export class SplashComponent implements OnInit {

	constructor() {}

	ngOnInit(): void {
	}
}