import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {Sales} from '../_models/sales';
import {BaseHttpService} from './base-http.service';
import {Model} from '../_models/model';
import {AlertService} from './alert.service';

@Injectable({
  providedIn: 'root'
})
export class SalesService extends BaseHttpService {

    protected resource = 'sales';

    constructor(protected http: HttpClient, protected alertService: AlertService) {
        super(http, alertService);
    }

    protected createModel(item): Model {
        return new Sales(item);
    }
}
