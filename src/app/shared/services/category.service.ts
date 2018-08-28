import { Injectable } from "@angular/core";

import {Category} from "../interfaces/category";
import{Observable} from "rxjs";
import {HttpClient} from "@angular/common/http";

@Injectable()
export class CategoryService {
	constructor(protected http: HttpClient) {}

	//define the Api endpoint
	private categoryUrl = "api/category/";

	//call to the category API and get the category based on the Category's ID
	getCategory(categoryId : string) : Observable<Category> {
		return(this.http.get<Category>(this.categoryUrl + categoryId));
	}

	//call to API to get an array of all the comments in the DataBase
	getAllCategories() : Observable<Category[]> {
		return(this.http.get<Category[]>(this.categoryUrl));
	}
}