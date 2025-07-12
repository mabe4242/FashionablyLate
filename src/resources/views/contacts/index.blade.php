@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contacts/index.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/parts/pagination.css') }}">
@endsection

@section('auth')
    @if (Auth::check())
        <form class="auth-form" action="/logout" method="POST">
            @csrf
            <button class="header-nav__button">logout</button>
        </form>
    @endif
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
        <form class="search-form" action="/search" method="GET">
            @csrf
            <div class="search-form__item">
                <input class="search-form__item-input" type="text" name="keyword"
                    placeholder="名前やメールアドレスを入力してください" value="{{ request('keyword') }}" />
                <div class="select-wrap">
                    <select class="search-form__item-select" name="gender">
                        <option value="">性別</option>
                        <option value="">全て</option>
                        <option value="1" {{ request('gender') == 1 ? 'selected' : '' }}>男性</option>
                        <option value="2" {{ request('gender') == 2 ? 'selected' : '' }}>女性</option>
                        <option value="3" {{ request('gender') == 3 ? 'selected' : '' }}>その他</option>
                    </select>
                </div>
                <div class="select-wrap">
                    <select class="search-form__item-select" name="category_id">
                        <option value="">お問い合わせの種類</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category['content'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <input type="date" name="created_at" value="{{ request('created_at') }}"
                    placeholder="年/月/日" class="search-form__item-date">
            </div>
            <div class="search-form__button">
                <button class="search-form__button-submit" type="submit">検索</button>
            </div>
            <div class="reset-button">
                <a href="/admin" class="reset-button__text">リセット</a>
            </div>
        </form>
        <div class="button-area">
            <div class="export-button">
                <a href="{{ route('contacts.export', request()->query()) }}" class="export-button__text">エクスポート</a>
            </div>
            <div class="pagination">
                {{ $contacts->links('vendor.pagination.default') }}
            </div>
        </div>
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
