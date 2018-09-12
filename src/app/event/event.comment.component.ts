import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {AuthService} from "../shared/services/auth.service"

//Interfaces used by comment component

import {Comment} from "../shared/interfaces/comment";
import {Event} from "../shared/interfaces/event";
import {Profile} from "../shared/interfaces/profile";

//Services needed

import {EventService} from "../shared/services/event.service";
import {ProfileService} from "../shared/services/profile.service";
import {CommentService} from "../shared/services/comment.service";

// Status and router

import {Status} from "../shared/interfaces/status";
import {ActivatedRoute} from "@angular/router";

@Component({
	template: require("./event.comment.component.html"),
	selector: "comment"
})

export class EventCommentComponent implements OnInit {
	event: Event;
	profile: Profile;
	comment: Comment;
	comments: Comment[] = [];
	eventId = this.route.snapshot.params["eventId"];
	tempComments: any[];
	createCommentForm: FormGroup;
	status: Status = null;
	isAuthenticated: boolean = null;

	constructor(
		protected formBuilder: FormBuilder,
		protected commentService: CommentService,
		protected eventService: EventService,
		protected profileService: ProfileService,
		protected route: ActivatedRoute,
		protected authService: AuthService
	) {
}

ngOnInit(): void {
	this.loadComments();
	this.isAuthenticated = this.authService.isAuthenticated();
	this.eventService.getEvent(this.eventId).subscribe(reply => this.event = reply);
	this.createCommentForm = this.formBuilder.group({
		commentContent: ["", [Validators.maxLength(500), Validators.required]]
	});
}

loadComments() : any {
	this.commentService.getCommentByCommentEventId(this.eventId).subscribe(comments => this.tempComments = comments);
}

createEventComment(): any {
	let comment: Comment = {
		commentId: null,
		commentEventId: this.eventId,
		commentProfileId: null,
		commentContent: this.createCommentForm.value.commentContent,
		commentDateTime: null,
		profileAtHandle: null

	};

	this.commentService.createComment(comment)
		.subscribe(status => {
			this.status = status;

			if(status.status === 200) {
				this.createCommentForm.reset();
				this.loadComments();
			}
		});
}

}