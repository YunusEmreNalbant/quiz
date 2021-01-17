<x-app-layout>
    <x-slot name="header">Quizler</x-slot>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{route('quizzes.create')}}" class="btn btn-sm btn-primary"><i class="fa fa-plus">Quiz
                        Oluştur</i></a>
            </h5>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Quiz</th>
                    <th scope="col">Soru Sayısı</th>
                    <th scope="col">Durum</th>
                    <th scope="col">Bitiş Tarihi</th>
                    <th scope="col">İşlemler</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quizzes as $quiz)
                    <tr>
                        <td>{{$quiz->title}}</td>
                        <td>{{$quiz->questions_count}}</td>
                        <td>
                            @switch($quiz->status)
                                @case('publish')
                                <span class="badge badge-success">Aktif</span>
                                @break
                                @case('passive')
                                <span class="badge badge-danger">Pasif</span>
                                @break
                                @case('draft')
                                <span class="badge badge-warning">Taslak</span>
                                @break
                            @endswitch
                        </td>
                        <td>
                            <span title="{{$quiz->finished_at}}">{{$quiz->finished_at ? $quiz->finished_at->diffForHumans() : ''}}</span>

                        </td>
                        <td>
                            <a href="{{route('quizzes.edit',$quiz->id)}}" class="btn btn-sm btn-primary"><i
                                    class="fa fa-pen"></i></a>
                            <a href="{{route('quizzes.destroy',$quiz->id)}}" class="btn btn-sm btn-danger"><i
                                    class="fa fa-times"></i></a>
                            <a href="{{route('questions.index',$quiz->id)}}" class="btn btn-sm btn-warning"><i
                                    class="fa fa-question"></i></a>
                        </td>
                    </tr>
                @endforeach

                </tbody>
                </tbody>
            </table>
            {{$quizzes->links()}}
        </div>
    </div>
</x-app-layout>
