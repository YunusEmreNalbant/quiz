<x-app-layout>
    <x-slot name="header">{{$quiz->title}}</x-slot>
    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Puan
                            <span class="badge badge-success badge-pill">{{$quiz->my_result->point}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Doğru / Yanlış Sayısı
                            <div class="float-right">
                                <span class="badge badge-warning badge-pill">{{$quiz->my_result->correct}} Doğru </span>
                                <span class="badge badge-danger badge-pill">{{$quiz->my_result->wrong}} Yanlış </span>
                            </div>

                        </li>
                        @if($quiz->finished_at)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Son Katılım Tarihi
                                <span title="{{$quiz->finished_at}}" class="badge badge-secondary badge-pill">{{$quiz->finished_at->diffForHumans()}}</span>
                            </li>
                        @endif
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Soru Sayısı
                            <span class="badge badge-secondary badge-pill">{{$quiz->questions_count}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Ortalama Puan
                            <span class="badge badge-secondary badge-pill">60</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Katılımcı Sayısı
                            <span class="badge badge-secondary badge-pill">14</span>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8">
                    <p class="card-text">
                        {{$quiz->description}}
                    </p>
                    <a href="{{route('quiz.join',$quiz->slug)}}" class="btn btn-primary btn-block">Quiz'e Katıl</a>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
