import {BrowserModule} from '@angular/platform-browser';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {NgModule} from '@angular/core';
import {HttpClientModule} from '@angular/common/http';
import { LOCALE_ID } from '@angular/core';
import { registerLocaleData } from '@angular/common';
import localePt from '@angular/common/locales/pt';
registerLocaleData(localePt);

import {
    MatListModule, MatButtonModule, MatIconModule,
    MatPaginatorModule, MatProgressSpinnerModule, MatInputModule, MatDialogModule,
    MatTableModule, MatCardModule, MatProgressBarModule
} from '@angular/material';


import {FormsModule} from '@angular/forms';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {SaveComponent} from './sellers/save/save.component';
import { CurrencyFormatPipe } from './_pipes/currency-format.pipe';
import { SellersComponent } from './sellers/sellers.component';
import { SalesComponent } from './sales/sales.component';
import { CreateComponent as CreateSalesComponent } from './sales/create/create.component';

@NgModule({
    declarations: [
        AppComponent,
        SaveComponent,
        CurrencyFormatPipe,
        SellersComponent,
        SalesComponent,
        CreateSalesComponent
    ],
    imports: [
        BrowserModule,
        BrowserAnimationsModule,
        HttpClientModule,
        AppRoutingModule,
        FormsModule,

        MatIconModule,
        MatListModule,
        MatButtonModule,
        MatPaginatorModule,
        MatProgressSpinnerModule,
        MatInputModule,
        MatDialogModule,
        MatTableModule,
        MatCardModule,
        MatProgressBarModule
    ],
    providers: [
        { provide: LOCALE_ID, useValue: 'pt-BR' }
    ],
    bootstrap: [
        AppComponent
    ],
    entryComponents: [
        SaveComponent,
        SalesComponent,
        CreateSalesComponent
    ]
})
export class AppModule {
}
