@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contacts/index.css') }}" />
@endsection

@section('content')
    <div class="contact__alert">
        @if (session('message'))
            <div class="contact__alert--success">{{ session('message') }}</div>
        @endif
    </div>
    <div class="contact__content">
        <div class="section__title">
            <h2>Admin</h2>
        </div>

        {{-- ！！！！！！！ここに検索など！！！！！！！ --}}

        <div class="contact-table">
            <table class="contact-table__inner">
                <tr class="contact-table__row">
                    <th class="contact-table__header">お名前</th>
                    <th class="contact-table__header">性別</th>
                    <th class="contact-table__header">メールアドレス</th>
                    <th class="contact-table__header">お問い合わせの種類</th>
                    <th class="contact-table__header"></th>
                </tr>
                @foreach ($contacts as $contact)
                    <tr class="contact-table__row">
                        <td class="contact-table__item">{{ $contact['name'] }}</td>
                        <td class="contact-table__item">{{ $contact['gender_type'] }}</td>
                        <td class="contact-table__item">{{ $contact['email'] }}</td>
                        <td class="contact-table__item">{{ $contact['category']['content'] }}</td>
                        <td class="contact-table__item">
                            {{-- モーダルを開く詳細ボタン --}}
                            <label for="modal-{{ $contact['id'] }}" class="modal-open-button">詳細</label>
                            <input type="checkbox" id="modal-{{ $contact['id'] }}" class="modal-toggle" hidden>
                            {{-- モーダル表示部分 --}}
                            <div class="modal-overlay">
                                <label for="modal-{{ $contact['id'] }}" class="modal-background"></label>
                                <div class="modal-content">
                                    {{-- 閉じるボタン（右上） --}}
                                    <label for="modal-{{ $contact['id'] }}" class="modal-close">&times;</label>
                                    <div class="modal-body">
                                        <div class="detail-row">
                                            <div class="detail-label">お名前</div>
                                            <div class="detail-value">{{ $contact['name'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">性別</div>
                                            <div class="detail-value">{{ $contact['gender_type'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">メールアドレス</div>
                                            <div class="detail-value">{{ $contact['email'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">電話番号</div>
                                            <div class="detail-value">{{ $contact['tel'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">住所</div>
                                            <div class="detail-value">{{ $contact['address'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">建物名</div>
                                            <div class="detail-value">{{ $contact['building'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">お問い合わせの種類</div>
                                            <div class="detail-value">{{ $contact['category']['content'] }}</div>
                                        </div>
                                        <div class="detail-row">
                                            <div class="detail-label">お問い合わせ内容</div>
                                            <div class="detail-value">{{ $contact['detail'] }}</div>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="/delete" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $contact['id'] }}">
                                                <button class="delete-button" type="submit">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
