import {Component, Inject, OnInit} from '@angular/core';
import {AppLoaderService} from '../_services/app-loader.service';
import {AlertService} from '../_services/alert.service';
import {MAT_DIALOG_DATA, MatDialog, MatDialogRef} from '@angular/material';
import {dataSaveComponent} from '../sellers/save/save.component';
import {Seller} from '../_models/seller';
import {SalesService} from '../_services/sales.service';
import {CreateComponent as SalesCreateComponent, dataSalesCreateComponent} from './create/create.component';

export interface dataSalesComponent {
    seller: Seller;
    onSaved(seller: Seller);
}

@Component({
    selector: 'app-sales',
    templateUrl: './sales.component.html',
    styleUrls: ['./sales.component.scss']
})
export class SalesComponent implements OnInit {

    seller: Seller;
    dataSource;
    displayedColumns: string[] = ['id', 'commission', 'amount', 'created_at'];

    constructor(
        private salesService: SalesService,
        private appLoaderService: AppLoaderService,
        public dialog: MatDialog,
        private alertService: AlertService,
        public dialogRef: MatDialogRef<SalesComponent>,
        @Inject(MAT_DIALOG_DATA) public dataDialog: dataSaveComponent) {
        this.seller = dataDialog.seller;
    }

    ngOnInit() {
        this.list();
    }

    list() {
        this.appLoaderService.startLoading();
        this.salesService
            .list({seller_id: this.seller.getKey()})
            .subscribe(
                (result) => {
                    this.appLoaderService.stopLoading();
                    this.dataSource = result['data'];
                },
                () => {
                    this.appLoaderService.stopLoading();
                }
            );
    }

    create() {
        const dialogRef = this.dialog.open(SalesCreateComponent, {
            width: '500px',
            data: <dataSalesCreateComponent>{
                seller: this.seller,
                onSaved: () => {
                    this.list();
                    this.dataDialog.onSaved(this.seller);
                }
            }
        });
    }

}
