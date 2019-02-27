import {Component, OnInit} from '@angular/core';
import {AppLoaderService} from './_services/app-loader.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.scss']
})
export class AppComponent  implements OnInit {

    isLoading: boolean;

    constructor(
        public appLoaderService: AppLoaderService
    ) {
        appLoaderService.isLoading.subscribe((value) => {
            setTimeout(() => {
                this.isLoading = value;
            }, 100)
        });
    }

    ngOnInit(): void {
    }

}
