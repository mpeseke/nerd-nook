import {Injectable} from "@angular/core";

import{Status} from "../interfaces/status";
import {Comment} from "../interfaces/comment"
import {Observable} from "rxjs/internal/Observable";
import {HttpClient} from "@angular/common/http";

@injectable ()
export class CommentService {
		//define the API end point
	private commentUrl = "api/comment/";

	constructor(protected http : HttpClient ) {}

	//call to the comment API and delete the comment in question
	deleteComment(commentId: string) : Observable<Status> {
		return(this.http.delete<Status>(this.commentUrl + commentId));
	}

	//call to the comment API anf create the comment in question
	editComment(comment : Comment) : Observable<Status> {
		return(this.http.post<Status>(this.commentUrl. comment));
	}

	// call to the comment API anf get a comment based on its ID
	createComment(commentId : string) : Observable<Comment> {
		return(this.http.post<Comment>(this.commentUrl + commentId));
	}

	// call to the comment API anf get a comment based on its ID
	getComment(commentId : string) : Observable<Comment> {
		return(this.http.post<Comment>(this.commentUrl + commentId));
	}

	// call to the API and get an array of comments based off the event id
	getCommentByCommentEventId(commentEventId: string) : Observable<Comment[]> {
	return(this.http.get<Comment[]>(this.commentUrl + commentEventId));
	}

	// call to the API and get an array of comments based off the profile id
	getCommentByCommentProfileId(commentProfileId: string) : Observable<Comment[]> {
		return(this.http.get<Comment[]>(this.commentUrl + commentProfileId));
	}

	//call to the API and get an array of all the comments in the database
	getCommentByCommentContent(commentContent : string) : Observable<Comment[]> {
		return(this.http.get<Comment[]>(this.commentUrl + commentContent));
	}

}
