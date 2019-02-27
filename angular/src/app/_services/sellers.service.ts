import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {Seller} from '../_models/seller';
import {BaseHttpService} from './base-http.service';
import {Model} from '../_models/model';
import {AlertService} from './alert.service';

@Injectable({
  providedIn: 'root'
})
export class SellersService extends BaseHttpService {

    protected resource = 'sellers';

    constructor(protected http: HttpClient, protected alertService: AlertService) {
        super(http, alertService);
    }

    protected createModel(item): Model {
        return new Seller(item);
    }
}
