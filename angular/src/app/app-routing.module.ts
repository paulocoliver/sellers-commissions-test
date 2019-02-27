import {NgModule} from '@angular/core';
import {Routes, RouterModule} from '@angular/router';
import {SellersComponent} from './sellers/sellers.component';

const routes: Routes = [
    {
        path: 'sellers',
        component: SellersComponent
    },
    {
        path: '',
        redirectTo: '/sellers',
        pathMatch: 'full'
    },
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule {
}
