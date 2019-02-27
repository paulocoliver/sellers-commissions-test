import {Component, OnInit, ChangeDetectorRef} from '@angular/core';
import {MatDialog} from '@angular/material';
import {SellersService} from '../_services/sellers.service';
import {Seller} from '../_models/seller';
import {SaveComponent, dataSaveComponent} from './save/save.component';
import {AlertService} from '../_services/alert.service';
import {AppLoaderService} from '../_services/app-loader.service';
import {SalesComponent, dataSalesComponent} from '../sales/sales.component';

@Component({
  selector: 'app-sellers',
  templateUrl: './sellers.component.html',
  styleUrls: ['./sellers.component.scss']
})
export class SellersComponent implements OnInit {

    dataSource;
    displayedColumns: string[] = ['id', 'name', 'email', 'commissions', 'created_at'];
    textFilter;

    constructor(private sellersService: SellersService,
                private cd: ChangeDetectorRef,
                public dialog: MatDialog,
                private alertService: AlertService,
                private appLoaderService: AppLoaderService,
    ) { }

    ngOnInit() {
        this.list();
    }

    ngAfterViewInit(): void {
        this.cd.detectChanges();
    }

    filter() {
        this.list();
    }

    list() {
        this.appLoaderService.startLoading();
        this.sellersService
            .list({q: this.textFilter || ''})
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

    openSaveSeller(seller: Seller): void {
        const dialogRef = this.dialog.open(SaveComponent, {
            width: '500px',
            data: <dataSaveComponent>{
                seller: new Seller(seller.attrsToSave()),
                onSaved: () => {
                    this.list();
                },
                onDeleted: () => {
                    this.list();
                }
            }
        });
    }

    create() {
        this.openSaveSeller(new Seller());
    }

    edit(seller: Seller) {
        this.openSaveSeller(seller);
    }

    openSales(seller: Seller, $event: MouseEvent) {
        $event.stopPropagation();

        const dialogRef = this.dialog.open(SalesComponent, {
            width: '700px',
            data: <dataSalesComponent>{
                seller: new Seller(seller.attrsToSave()),
                onSaved: () => {
                    this.list();
                }
            }
        });

    }
}
