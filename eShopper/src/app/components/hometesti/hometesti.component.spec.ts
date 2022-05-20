import { ComponentFixture, TestBed } from '@angular/core/testing';

import { HometestiComponent } from './hometesti.component';

describe('HometestiComponent', () => {
  let component: HometestiComponent;
  let fixture: ComponentFixture<HometestiComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ HometestiComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(HometestiComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
