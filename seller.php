<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>MimiEats | Seller Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Righteous&display=swap" rel="stylesheet">
<style>
:root{
  --orange:#ffb74d;--orange-dark:#f57c00;--orange-light:#fff3e0;--orange-mid:#ffe0b2;
  --pink:#f06292;--pink-light:#fce4ec;--pink-dark:#e91e8c;
  --bg:#fffaf5;--white:#ffffff;--gray:#f5f5f5;--gray2:#e8e8ee;
  --text:#1a1a2e;--text2:#666;--text3:#aaa;
  --green:#4caf50;--red:#ef5350;--purple:#9c27b0;
  --radius:18px;--radius-sm:12px;--shadow:0 2px 12px rgba(0,0,0,.08);
}
*{box-sizing:border-box;margin:0;padding:0;-webkit-tap-highlight-color:transparent}
html{background:#888;display:flex;justify-content:center;min-height:100vh}
body{font-family:'Nunito',sans-serif;background:var(--bg);width:100%;max-width:430px;
  min-width:320px;height:100vh;display:flex;flex-direction:column;overflow:hidden;
  position:relative;box-shadow:0 0 60px rgba(0,0,0,.4)}
.screen{position:absolute;inset:0;display:flex;flex-direction:column;background:var(--bg);
  transition:transform .3s cubic-bezier(.4,0,.2,1),opacity .3s;z-index:1}
.screen.hidden{transform:translateX(100%);opacity:0;pointer-events:none}
.login-bg{display:flex;flex-direction:column;align-items:center;padding:20px;gap:0;overflow-y:auto;
  background:linear-gradient(160deg,#fffde7 0%,#ffe0b2 50%,#fce4ec 100%)}
.login-logo{font-family:'Righteous',cursive;font-size:2.4rem;
  background:linear-gradient(135deg,#f57c00,#f48fb1);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:2px}
.login-sub{font-size:.75rem;color:var(--text2);font-weight:800;margin-bottom:24px}
.login-card{background:var(--white);border-radius:20px;padding:22px;width:100%;box-shadow:0 8px 30px rgba(0,0,0,.1)}
.login-card h2{font-size:.95rem;font-weight:900;margin-bottom:16px;color:var(--text)}
.seller-list{display:flex;flex-direction:column;gap:9px;margin-bottom:14px}
.seller-login-item{display:flex;align-items:center;gap:12px;padding:11px;border-radius:var(--radius-sm);border:1.5px solid var(--gray2);cursor:pointer;transition:.2s}
.seller-login-item:active{border-color:var(--orange);background:var(--orange-light)}
.sli-avi{width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#ffe0b2,#ffd180);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.sli-info{flex:1}
.sli-name{font-weight:800;font-size:.83rem}
.sli-id{font-size:.68rem;color:var(--text2)}
.divider-or{text-align:center;font-size:.72rem;color:var(--text3);font-weight:700;margin:10px 0;position:relative}
.divider-or::before,.divider-or::after{content:'';position:absolute;top:50%;width:42%;height:1px;background:var(--gray2)}
.divider-or::before{left:0}.divider-or::after{right:0}
.new-shop-input{width:100%;border:1.5px solid var(--gray2);border-radius:var(--radius-sm);padding:9px 12px;font-family:'Nunito',sans-serif;font-size:.8rem;outline:none;margin-bottom:7px;transition:.2s}
.new-shop-input:focus{border-color:var(--orange)}
.btn-new-shop{width:100%;background:linear-gradient(135deg,var(--orange),var(--orange-dark));color:#fff;border:none;padding:12px;border-radius:var(--radius-sm);font-family:'Nunito',sans-serif;font-weight:900;font-size:.85rem;cursor:pointer}
.dash-header{background:linear-gradient(135deg,#fffde7 0%,#ffe0b2 100%);padding:14px 18px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--orange-mid);position:relative;z-index:10;box-shadow:0 2px 10px rgba(255,183,77,.2)}
.dash-avi{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#ffd180,#ffcc02);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.dash-info{flex:1}
.dash-name{font-weight:900;font-size:.9rem;color:var(--text)}
.dash-status{font-size:.67rem;color:var(--green);font-weight:700}
.btn-logout{background:var(--gray);border:none;padding:6px 12px;border-radius:8px;font-family:'Nunito',sans-serif;font-size:.68rem;font-weight:700;cursor:pointer;color:var(--text2)}
.bottom-nav{position:absolute;bottom:0;left:0;right:0;background:var(--white);border-top:1px solid var(--gray2);display:flex;z-index:100;box-shadow:0 -4px 20px rgba(0,0,0,.08)}
.nav-item{flex:1;display:flex;flex-direction:column;align-items:center;gap:2px;padding:10px 0 14px;cursor:pointer;font-size:.6rem;font-weight:700;color:var(--text3);transition:.2s;position:relative}
.nav-item.active{color:var(--orange-dark)}
.nav-icon{font-size:1.25rem;transition:.2s}
.nav-item.active .nav-icon{transform:scale(1.15)}
.nav-badge{position:absolute;top:6px;right:calc(50% - 16px);background:var(--red);color:#fff;border-radius:50%;width:14px;height:14px;font-size:.52rem;font-weight:900;display:none;align-items:center;justify-content:center}
.nav-badge.show{display:flex}
.content-scroll{flex:1;overflow-y:auto;padding:14px 18px 100px;display:flex;flex-direction:column;gap:12px}
.content-scroll::-webkit-scrollbar{width:3px}
.content-scroll::-webkit-scrollbar-thumb{background:var(--orange-light)}
.order-card{background:var(--white);border-radius:var(--radius);padding:14px;box-shadow:var(--shadow);border-left:4px solid var(--orange);animation:fadeUp .3s}
.order-card.nego{border-left-color:var(--purple)}
.order-card.delivered{border-left-color:var(--green);opacity:.7}
.order-top{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px}
.order-buyer{font-weight:900;font-size:.85rem}
.order-buyer-id{font-size:.68rem;color:var(--text2);font-weight:700;margin-top:2px}
.order-items{font-size:.77rem;color:var(--text2);line-height:1.7;margin-bottom:10px;background:var(--gray);border-radius:8px;padding:8px 10px;white-space:pre-line}
.order-addr{font-size:.72rem;color:var(--text2);margin-bottom:6px}
.order-addr span{font-weight:700;color:var(--text)}
.order-total{font-size:.78rem;font-weight:900;color:var(--orange-dark);margin-bottom:10px}
.order-actions{display:flex;gap:7px;flex-wrap:wrap}
.btn-accept{background:var(--green);color:#fff;border:none;padding:7px 14px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.72rem;cursor:pointer}
.btn-reject{background:var(--red);color:#fff;border:none;padding:7px 14px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.72rem;cursor:pointer}
.btn-bill{background:var(--purple);color:#fff;border:none;padding:7px 14px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.72rem;cursor:pointer}
.btn-delivered{background:var(--green);color:#fff;border:none;padding:7px 14px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.72rem;cursor:pointer}
.status-badge{font-size:.67rem;font-weight:800;padding:3px 8px;border-radius:50px;display:inline-block}
.status-badge.accepted{background:#e8f5e9;color:var(--green)}
.status-badge.rejected{background:#ffebee;color:var(--red)}
.status-badge.pending{background:#fff9c4;color:#f57f17}
.status-badge.delivered{background:#e8f5e9;color:var(--green)}
.nego-card{background:var(--white);border-radius:var(--radius);padding:14px;box-shadow:var(--shadow);border-left:4px solid var(--purple);animation:fadeUp .3s}
.nego-offer{background:var(--orange-light);border-radius:8px;padding:8px 10px;font-size:.8rem;margin:8px 0}
.nego-offer .original{text-decoration:line-through;color:var(--text3);font-size:.72rem}
.nego-offer .offered{font-weight:900;font-size:.88rem;color:var(--purple)}
.nego-min-warn{background:#ffebee;border-radius:8px;padding:6px 10px;font-size:.72rem;color:var(--red);font-weight:700;margin-top:4px}
.tender-req{background:var(--white);border-radius:var(--radius);padding:14px;box-shadow:var(--shadow);border-left:4px solid var(--pink);animation:fadeUp .3s}
.bid-input-wrap{display:flex;gap:8px;margin-top:8px}
.bid-input{flex:1;border:1.5px solid var(--gray2);border-radius:8px;padding:8px 10px;font-family:'Nunito',sans-serif;font-size:.8rem;outline:none}
.bid-input:focus{border-color:var(--orange)}
.btn-bid{background:var(--pink);color:#fff;border:none;padding:8px 14px;border-radius:8px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.74rem;cursor:pointer}
.chat-header{background:var(--white);padding:12px 18px;display:flex;align-items:center;gap:10px;border-bottom:1px solid var(--gray2);box-shadow:0 2px 8px rgba(0,0,0,.06)}
.chat-msgs-wrap{flex:1;overflow-y:auto;padding:12px;display:flex;flex-direction:column;gap:8px;padding-bottom:140px}
.chat-msg{max-width:78%;padding:10px 12px;border-radius:14px;font-size:.8rem;line-height:1.5;animation:fadeUp .25s}
.chat-msg.buyer-msg{background:var(--white);border:1px solid var(--gray2);align-self:flex-start;border-radius:14px 14px 14px 4px}
.chat-msg.seller-out{background:var(--orange);color:#fff;align-self:flex-end;border-radius:14px 14px 4px 14px}
.chat-msg .msg-time{font-size:.58rem;opacity:.6;margin-top:3px;text-align:right}
.chat-msg.buyer-msg .msg-time{text-align:left}
.seller-order-card{background:linear-gradient(135deg,#fff8f0,#fff3e0);border:2px solid var(--orange);border-radius:14px;padding:12px;align-self:flex-start;max-width:92%;box-shadow:0 2px 8px rgba(255,183,77,.2)}
.seller-order-title{font-weight:900;font-size:.78rem;color:var(--orange-dark);margin-bottom:6px}
.seller-order-row{display:flex;justify-content:space-between;font-size:.72rem;padding:2px 0;border-bottom:1px dashed #ffe082;color:var(--text2)}
.seller-order-total{font-weight:900;color:var(--pink);font-size:.82rem;text-align:right;margin-top:6px}
.bill-msg{background:var(--orange-light);border:1.5px solid var(--orange);border-radius:14px;padding:12px;align-self:flex-end;max-width:88%}
.bill-msg-title{font-weight:900;font-size:.78rem;color:var(--orange-dark);margin-bottom:6px}
.bill-msg-row{display:flex;justify-content:space-between;font-size:.73rem;padding:2px 0;border-bottom:1px dashed #ffe082}
.bill-msg-total{font-weight:900;color:var(--pink);font-size:.83rem;text-align:right;margin-top:6px}
.bill-builder{background:var(--white);border-top:2px solid var(--orange-mid);padding:12px 14px;display:none;flex-direction:column;gap:8px}
.bill-builder.open{display:flex}
.bill-builder-title{font-size:.77rem;font-weight:900;color:var(--orange-dark);display:flex;justify-content:space-between;align-items:center}
.bill-rows{display:flex;flex-direction:column;gap:6px;max-height:130px;overflow-y:auto}
.bill-row-input{display:flex;gap:5px;align-items:center}
.bill-row-input input[type="text"]{flex:2;border:1px solid var(--gray2);border-radius:7px;padding:6px 8px;font-family:'Nunito',sans-serif;font-size:.74rem;outline:none}
.bill-row-input input[type="number"]{flex:1;border:1px solid var(--gray2);border-radius:7px;padding:6px 8px;font-family:'Nunito',sans-serif;font-size:.74rem;outline:none;min-width:0}
.btn-rm{background:#ffebee;border:none;border-radius:6px;color:var(--red);width:26px;height:26px;cursor:pointer;font-weight:900;font-size:.8rem;flex-shrink:0}
.bill-actions{display:flex;gap:8px}
.btn-add-row{background:#e8f5e9;border:1px solid #a5d6a7;color:var(--green);border-radius:7px;padding:6px 10px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.7rem;cursor:pointer;flex:1}
.btn-send-bill{background:var(--orange-dark);color:#fff;border:none;border-radius:7px;padding:6px 14px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.7rem;cursor:pointer;flex:1}
.bill-total-preview{font-size:.74rem;font-weight:900;color:var(--pink);text-align:right}
.chat-input-area{background:var(--white);border-top:1px solid var(--gray2);padding:8px 12px;display:flex;gap:8px;align-items:center}
.chat-input-area input{flex:1;border:1.5px solid var(--gray2);border-radius:50px;padding:9px 14px;font-family:'Nunito',sans-serif;font-size:.8rem;outline:none}
.chat-input-area input:focus{border-color:var(--orange)}
.btn-toggle-bill{background:var(--orange-light);border:1px solid var(--orange);border-radius:50%;width:36px;height:36px;font-size:1rem;cursor:pointer;flex-shrink:0}
.btn-send-msg{background:var(--orange);color:#fff;border:none;width:36px;height:36px;border-radius:50%;cursor:pointer;font-size:.9rem;flex-shrink:0;display:flex;align-items:center;justify-content:center}
.profile-section{background:var(--white);border-radius:var(--radius);padding:16px;box-shadow:var(--shadow)}
.profile-emoji-picker{display:flex;gap:8px;flex-wrap:wrap;margin:10px 0}
.pep-item{font-size:1.5rem;padding:6px;border-radius:8px;cursor:pointer;border:2px solid transparent;transition:.2s}
.pep-item.selected{border-color:var(--orange);background:var(--orange-light)}
.profile-input{width:100%;border:1.5px solid var(--gray2);border-radius:var(--radius-sm);padding:10px 12px;font-family:'Nunito',sans-serif;font-size:.82rem;outline:none;margin-bottom:8px;transition:.2s}
.profile-input:focus{border-color:var(--orange)}
.btn-save-profile{width:100%;background:var(--orange);color:#fff;border:none;padding:12px;border-radius:var(--radius-sm);font-family:'Nunito',sans-serif;font-weight:900;font-size:.85rem;cursor:pointer}
.stats-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.stat-card{background:var(--white);border-radius:var(--radius-sm);padding:14px;box-shadow:var(--shadow);text-align:center}
.stat-val{font-size:1.4rem;font-weight:900;color:var(--orange-dark)}
.stat-lbl{font-size:.68rem;color:var(--text2);margin-top:3px;font-weight:700}
.min-price-box{background:linear-gradient(135deg,#fff8f0,var(--orange-light));border:1.5px solid var(--orange);border-radius:var(--radius-sm);padding:12px;margin-bottom:8px}
.min-price-box h4{font-size:.78rem;font-weight:900;color:var(--orange-dark);margin-bottom:6px}
.min-price-wrap{display:flex;gap:8px;align-items:center}
.min-price-wrap input{flex:1;border:1.5px solid var(--orange);border-radius:8px;padding:8px 10px;font-family:'Nunito',sans-serif;font-size:.85rem;outline:none;color:var(--orange-dark);font-weight:700}
.btn-save-min{background:var(--orange-dark);color:#fff;border:none;padding:8px 14px;border-radius:8px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.74rem;cursor:pointer}
.rating-item{background:var(--gray);border-radius:10px;padding:10px;font-size:.74rem;margin-bottom:6px}
.rating-stars{color:var(--orange-dark);font-size:.85rem;font-weight:900}
.rating-buyer{font-size:.68rem;color:var(--text3);margin-top:2px}
.chat-conv-item{background:var(--white);border-radius:var(--radius-sm);padding:12px;display:flex;gap:10px;align-items:center;box-shadow:var(--shadow);cursor:pointer;transition:.2s}
.chat-conv-item:active{transform:scale(.98)}
.chat-conv-avi{width:44px;height:44px;border-radius:12px;background:var(--pink-light);display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0}
.marquee-wrap{background:var(--orange-dark);overflow:hidden;padding:4px 0}
.marquee-track{display:flex;white-space:nowrap;animation:marqueeRun 22s linear infinite}
.marquee-track span{font-size:.62rem;font-weight:800;color:#fff;letter-spacing:.7px;padding:0 16px}
.marquee-track span::before{content:'🏪';margin-right:5px}
@keyframes marqueeRun{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
@keyframes fadeUp{from{opacity:0;transform:translateY(10px)}to{opacity:1;transform:translateY(0)}}
.toast{position:fixed;bottom:90px;left:50%;transform:translateX(-50%) translateY(20px);background:var(--text);color:#fff;padding:9px 18px;border-radius:50px;font-size:.75rem;font-weight:700;z-index:9999;opacity:0;transition:.3s;white-space:nowrap;max-width:90%}
.toast.show{opacity:1;transform:translateX(-50%) translateY(0)}
input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{-webkit-appearance:none}
input[type=number]{-moz-appearance:textfield}
</style>
</head>
<body>
<!-- LOGIN -->
<div class="screen login-bg" id="screen-login">
  <div class="login-logo">MimiEats 🏪</div>
  <div class="login-sub">Seller Dashboard</div>
  <div class="login-card">
    <h2>Select your shop</h2>
    <div class="seller-list" id="seller-list"></div>
    <div class="divider-or">or create new</div>
    <div style="display:flex;gap:8px;align-items:center;margin-bottom:8px">
      <span style="font-size:1.5rem" id="new-shop-emoji">🏪</span>
      <div style="display:flex;gap:5px;flex-wrap:wrap">
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🏪')">🏪</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🍳')">🍳</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🍜')">🍜</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🍛')">🍛</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🔥')">🔥</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🌸')">🌸</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🍰')">🍰</span>
        <span style="cursor:pointer;font-size:1.3rem" onclick="pickEmoji('🥩')">🥩</span>
      </div>
    </div>
    <input class="new-shop-input" id="new-shop-name" placeholder="Shop name (e.g. Warung Mama)">
    <input class="new-shop-input" id="new-shop-id" placeholder="Shop ID (e.g. @warungmama)">
    <input class="new-shop-input" id="new-shop-pin" type="password" placeholder="Set PIN (min 4 digits)" maxlength="8">
    <button class="btn-new-shop" onclick="createNewShop()">Create Shop & Enter</button>
  </div>
</div>
<!-- ORDERS -->
<div class="screen hidden" id="screen-orders">
  <div class="dash-header">
    <div class="dash-avi" id="dash-avi-orders">🏪</div>
    <div class="dash-info"><div class="dash-name" id="dash-name-orders">My Shop</div><div class="dash-status">🟢 Online</div></div>
    <button class="btn-logout" onclick="logout()">Switch</button>
  </div>
  <div class="marquee-wrap"><div class="marquee-track"><span>Accept orders fast</span><span>Delight your buyers</span><span>Quality wins</span><span>Best seller wins</span><span>Accept orders fast</span><span>Delight your buyers</span><span>Quality wins</span><span>Best seller wins</span></div></div>
  <div class="content-scroll" id="orders-list-wrap">
    <p id="orders-empty" style="text-align:center;color:var(--text3);font-size:.82rem;padding:30px">No orders yet. Waiting... 🕐</p>
  </div>
  <div class="bottom-nav">
    <div class="nav-item active" onclick="switchMainTab('orders')"><span class="nav-icon">📦</span>Orders<span class="nav-badge" id="nb-orders"></span></div>
    <div class="nav-item" onclick="switchMainTab('chat')"><span class="nav-icon">💬</span>Chat<span class="nav-badge" id="nb-chat"></span></div>
    <div class="nav-item" onclick="switchMainTab('menu')"><span class="nav-icon">🍽️</span>Menu</div>
    <div class="nav-item" onclick="switchMainTab('profile')"><span class="nav-icon">⚙️</span>Profile</div>
  </div>
</div>
<!-- CHAT LIST -->
<div class="screen hidden" id="screen-chat-list">
  <div class="dash-header">
    <div class="dash-avi" id="dash-avi-chat">🏪</div>
    <div class="dash-info"><div class="dash-name" id="dash-name-chat">My Shop</div><div class="dash-status">💬 Messages</div></div>
    <button class="btn-logout" onclick="logout()">Switch</button>
  </div>
  <div class="content-scroll" id="chat-list-wrap">
    <p id="chat-list-empty" style="text-align:center;color:var(--text3);font-size:.82rem;padding:30px">No conversations yet</p>
  </div>
  <div class="bottom-nav">
    <div class="nav-item" onclick="switchMainTab('orders')"><span class="nav-icon">📦</span>Orders<span class="nav-badge" id="nb-orders2"></span></div>
    <div class="nav-item active" onclick="switchMainTab('chat')"><span class="nav-icon">💬</span>Chat<span class="nav-badge" id="nb-chat2"></span></div>
    <div class="nav-item" onclick="switchMainTab('menu')"><span class="nav-icon">🍽️</span>Menu</div>
    <div class="nav-item" onclick="switchMainTab('profile')"><span class="nav-icon">⚙️</span>Profile</div>
  </div>
</div>
<!-- CHAT DETAIL -->
<div class="screen hidden" id="screen-chat-detail">
  <div class="chat-header">
    <button class="back-btn" style="background:none;border:none;font-size:1.2rem;cursor:pointer;color:var(--text);padding:4px" onclick="showScreen('screen-chat-list')">←</button>
    <div style="flex:1"><div style="font-weight:900;font-size:.88rem" id="chat-detail-buyer">Buyer</div><div style="font-size:.68rem;color:var(--green);font-weight:700">🟢 Active</div></div>
    <button onclick="clearThisChat()" style="background:#ffebee;border:1px solid #ffcdd2;color:#ef5350;padding:5px 10px;border-radius:50px;font-family:'Nunito',sans-serif;font-weight:800;font-size:.65rem;cursor:pointer">🗑️ Clear</button>
  </div>
  <div class="chat-msgs-wrap" id="chat-msgs"></div>
  <div style="position:absolute;bottom:0;left:0;right:0">
    <div class="bill-builder" id="bill-builder">
      <div class="bill-builder-title"><span>🧾 Bill Builder</span><span class="bill-total-preview" id="bill-total-preview">Total: Rp 0</span></div>
      <div class="bill-rows" id="bill-rows"></div>
      <div class="bill-actions"><button class="btn-add-row" onclick="addBillRow()">+ Item</button><button class="btn-send-bill" onclick="sendBill()">Send Bill 📨</button></div>
    </div>
    <div class="chat-input-area">
      <input type="text" id="chat-reply-input" placeholder="Reply to buyer..." onkeypress="if(event.key==='Enter')sendReply()">
      <button class="btn-toggle-bill" onclick="toggleBillBuilder()">🧾</button>
      <button class="btn-send-msg" onclick="sendReply()">➤</button>
    </div>
  </div>
</div>
<!-- PROFILE -->
<div class="screen hidden" id="screen-profile">
  <div class="dash-header">
    <div class="dash-avi" id="dash-avi-profile">🏪</div>
    <div class="dash-info"><div class="dash-name" id="dash-name-profile">My Shop</div><div class="dash-status">⚙️ Settings</div></div>
    <button class="btn-logout" onclick="logout()">Switch</button>
  </div>
  <div class="content-scroll">
    <div class="stats-grid">
      <div class="stat-card"><div class="stat-val" id="stat-orders">0</div><div class="stat-lbl">Total Orders</div></div>
      <div class="stat-card"><div class="stat-val" id="stat-rating">—</div><div class="stat-lbl">Avg Rating</div></div>
      <div class="stat-card"><div class="stat-val" id="stat-revenue">Rp 0</div><div class="stat-lbl">Est. Revenue</div></div>
      <div class="stat-card"><div class="stat-val" id="stat-chats">0</div><div class="stat-lbl">Active Chats</div></div>
    </div>
    <div class="min-price-box">
      <h4>🔒 Minimum Offer Price</h4>
      <p style="font-size:.7rem;color:var(--text2);margin-bottom:8px">Buyers cannot negotiate below this price. Set 0 to disable.</p>
      <div class="min-price-wrap">
        <input type="number" id="min-price-input" placeholder="e.g. 15000" min="0" step="500">
        <button class="btn-save-min" onclick="saveMinPrice()">Save</button>
      </div>
      <div id="min-price-status" style="font-size:.7rem;color:var(--green);margin-top:6px;font-weight:700"></div>
    </div>
    <div class="profile-section" style="margin-bottom:8px">
      <div style="font-size:.85rem;font-weight:900;margin-bottom:10px">⭐ Buyer Ratings</div>
      <div id="ratings-list"><p style="font-size:.75rem;color:var(--text3)">No ratings yet</p></div>
    </div>
    <div class="profile-section">
      <div style="font-size:.85rem;font-weight:900;margin-bottom:12px">✏️ Edit Shop Profile</div>
      <div style="font-size:.7rem;color:var(--text2);margin-bottom:6px;font-weight:700">Shop Icon</div>
      <div class="profile-emoji-picker" id="profile-emoji-picker">
        <span class="pep-item selected" onclick="selectProfileEmoji(this)">🏪</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🍳</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🍜</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🍛</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🔥</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🌸</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🍰</span>
        <span class="pep-item" onclick="selectProfileEmoji(this)">🥩</span>
      </div>
      <input class="profile-input" id="prof-name" placeholder="Shop name">
      <input class="profile-input" id="prof-id" placeholder="Shop ID (@handle)">
      <textarea class="profile-input" id="prof-desc" rows="2" placeholder="Short description..." style="resize:none"></textarea>
      <button class="btn-save-profile" onclick="saveProfile()">Save Changes ✓</button>
    </div>
    <div style="display:flex;gap:8px">
      <button onclick="clearAllChat()" style="flex:1;background:#ffebee;color:var(--red);border:1px solid #ffcdd2;padding:11px;border-radius:var(--radius-sm);font-family:'Nunito',sans-serif;font-weight:800;font-size:.78rem;cursor:pointer">💬 Clear Chat</button>
      <button onclick="clearAllOrders()" style="flex:1;background:#fff3e0;color:#f57c00;border:1px solid #ffe0b2;padding:11px;border-radius:var(--radius-sm);font-family:'Nunito',sans-serif;font-weight:800;font-size:.78rem;cursor:pointer">📦 Clear Orders</button>
    </div>
  </div>
  <div class="bottom-nav">
    <div class="nav-item" onclick="switchMainTab('orders')"><span class="nav-icon">📦</span>Orders<span class="nav-badge" id="nb-orders4"></span></div>
    <div class="nav-item" onclick="switchMainTab('chat')"><span class="nav-icon">💬</span>Chat<span class="nav-badge" id="nb-chat4"></span></div>
    <div class="nav-item" onclick="switchMainTab('menu')"><span class="nav-icon">🍽️</span>Menu</div>
    <div class="nav-item active" onclick="switchMainTab('profile')"><span class="nav-icon">⚙️</span>Profile</div>
  </div>
</div>
<!-- MENU -->
<div class="screen hidden" id="screen-menu">
  <div class="dash-header">
    <div class="dash-avi" id="dash-avi-menu">🏪</div>
    <div class="dash-info"><div class="dash-name" id="dash-name-menu">My Shop</div><div class="dash-status">🍽️ My Menu</div></div>
    <button class="btn-logout" onclick="logout()">Switch</button>
  </div>
  <div class="content-scroll" id="menu-list-wrap"></div>
  <div class="bottom-nav">
    <div class="nav-item" onclick="switchMainTab('orders')"><span class="nav-icon">📦</span>Orders<span class="nav-badge" id="nb-orders5"></span></div>
    <div class="nav-item" onclick="switchMainTab('chat')"><span class="nav-icon">💬</span>Chat<span class="nav-badge" id="nb-chat5"></span></div>
    <div class="nav-item active" onclick="switchMainTab('menu')"><span class="nav-icon">🍽️</span>Menu</div>
    <div class="nav-item" onclick="switchMainTab('profile')"><span class="nav-icon">⚙️</span>Profile</div>
  </div>
</div>
<div class="toast" id="toast"></div>
<div id="pin-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:99999;align-items:center;justify-content:center">
  <div style="background:#fff;border-radius:20px;padding:28px 24px;width:300px;box-shadow:0 8px 40px rgba(0,0,0,.2);text-align:center">
    <div style="font-size:1.8rem;margin-bottom:8px">🔐</div>
    <div id="pin-shop-name" style="font-weight:900;font-size:1rem;margin-bottom:4px">Enter PIN</div>
    <div style="font-size:.75rem;color:#aaa;margin-bottom:18px">Enter your shop PIN to continue</div>
    <input id="pin-input" type="password" maxlength="8" inputmode="numeric" placeholder="••••"
      style="width:100%;border:2px solid #f48fb1;border-radius:12px;padding:12px;font-size:1.4rem;text-align:center;letter-spacing:6px;outline:none;font-family:'Nunito',sans-serif;color:#1a1a2e"
      onkeydown="if(event.key==='Enter') submitPin()">
    <div id="pin-error" style="color:#ef5350;font-size:.75rem;font-weight:700;margin-top:8px;min-height:16px"></div>
    <div style="display:flex;gap:10px;margin-top:14px">
      <button onclick="cancelPin()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #eee;background:#fff;font-family:'Nunito',sans-serif;font-weight:800;font-size:.88rem;cursor:pointer;color:#888">Cancel</button>
      <button onclick="submitPin()" style="flex:1;padding:11px;border-radius:10px;border:none;background:linear-gradient(135deg,#f06292,#ffb74d);color:#fff;font-family:'Nunito',sans-serif;font-weight:900;font-size:.88rem;cursor:pointer">Enter</button>
    </div>
  </div>
</div>
<script>
const DEFAULT_SHOPS=[
  {name:"Mimi Kitchen",id:"@mimikitchen",emoji:"🌸",desc:"Cloud kitchen — fresh, affordable.",pin:"1234",menu:[{name:"Nasi Goreng",price:24000,cat:"rice",img:"https://images.unsplash.com/photo-1512058564366-18510be2db19?w=300&h=200&fit=crop"},{name:"Mie Goreng",price:16000,cat:"noodles",img:"https://images.unsplash.com/photo-1585032226651-759b368d7246?w=300&h=200&fit=crop"},{name:"Es Teler",price:12000,cat:"drinks",img:"https://images.unsplash.com/photo-1488477181946-6428a0291777?w=300&h=200&fit=crop"}]},
  {name:"Kedai Rasa Sayang",id:"@kedairasa",emoji:"🍳",desc:"Homemade vibes since 2018.",pin:"1234",menu:[{name:"Nasi Goreng",price:25000,cat:"rice",img:"https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=300&h=200&fit=crop"},{name:"Pisang Goreng",price:10000,cat:"sweet",img:"https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=300&h=200&fit=crop"}]},
  {name:"Ayam Bakar Madu Solo",id:"@ayammadu",emoji:"🍯",desc:"Legendary honey-glazed grilled chicken.",pin:"1234",menu:[{name:"Ayam Bakar",price:35000,cat:"savory",img:"https://images.unsplash.com/photo-1527477396000-e27163b481c2?w=300&h=200&fit=crop"}]},
  {name:"Penyetan Mas Jago",id:"@masjago",emoji:"🌶️",desc:"Spicy sambal specialist.",pin:"1234",menu:[{name:"Ayam Bakar Pedas",price:30000,cat:"spicy",img:"https://images.unsplash.com/photo-1611599537845-1c7aca0091c0?w=300&h=200&fit=crop"}]},
  {name:"Mie Ayam Wonogiri",id:"@miewonogiri",emoji:"🍜",desc:"Authentic Wonogiri-style noodles.",pin:"1234",menu:[{name:"Mie Ayam",price:15000,cat:"noodles",img:"https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=300&h=200&fit=crop"}]},
  {name:"Bakso Idola",id:"@bakso_idola",emoji:"🥣",desc:"Giant meatballs!",pin:"1234",menu:[{name:"Mie Ayam Spesial",price:18000,cat:"noodles",img:"https://images.unsplash.com/photo-1569050467447-ce54b3bbc37d?w=300&h=200&fit=crop"}]},
  {name:"Seblak Enjoy",id:"@seblakenjoy",emoji:"🔥",desc:"The spiciest seblak in town.",pin:"1234",menu:[{name:"Seblak",price:17500,cat:"spicy",img:"https://images.unsplash.com/photo-1626804475297-41608ea09aeb?w=300&h=200&fit=crop"}]},
  {name:"RM Sinar Minang",id:"@sinarminang",emoji:"🍛",desc:"Authentic Padang cuisine.",pin:"1234",menu:[{name:"Nasi Padang",price:22000,cat:"rice",img:"https://images.unsplash.com/photo-1604329760661-e71dc83f8f26?w=300&h=200&fit=crop"}]},
  {name:"Sate Madura Cak Edi",id:"@cakedi",emoji:"🍢",desc:"Traditional Madura satay.",pin:"1234",menu:[{name:"Sate Ayam",price:20000,cat:"snacks",img:"https://images.unsplash.com/photo-1529042410759-befb1204b468?w=300&h=200&fit=crop"}]},
  {name:"Bakso Solo Baru",id:"@baksosolobaru",emoji:"🥩",desc:"Premium beef meatballs.",pin:"1234",menu:[{name:"Bakso Sapi",price:18000,cat:"savory",img:"https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=300&h=200&fit=crop"}]},
  {name:"Martabak Bintang",id:"@martabakbintang",emoji:"🥞",desc:"Best sweet martabak, 15+ flavors!",pin:"1234",menu:[{name:"Martabak Manis",price:30000,cat:"sweet",img:"https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=300&h=200&fit=crop"}]},
];
let _sv=JSON.parse(localStorage.getItem('mimi_shops')||'null');
let shops=_sv?DEFAULT_SHOPS.map(d=>{const s=_sv.find(p=>p.id===d.id);return s?{...d,...s}:d;}).concat(_sv.filter(p=>!DEFAULT_SHOPS.find(d=>d.id===p.id))):DEFAULT_SHOPS.map(s=>({...s}));
let currentShop=null,billRows=[],newEmojiSelected='🏪',profileEmojiSelected='🏪',activeConvBuyer='Buyer';
let seenMsgIds=new Set(),convHistory={},orderCount=0,chatCount=0,currentScreen='screen-orders',pollTimer=null,shopMinPrice=0,totalRevenue=0;
function saveShops(){if(currentShop){const i=shops.findIndex(s=>s.id===currentShop.id);if(i>=0)shops[i]=currentShop;}localStorage.setItem('mimi_shops',JSON.stringify(shops));}
function showScreen(id){document.querySelectorAll('.screen').forEach(s=>{s.classList.add('hidden');s.style.zIndex='1';});const t=document.getElementById(id);if(!t)return;t.classList.remove('hidden');t.style.transform='';t.style.opacity='';t.style.zIndex='5';currentScreen=id;}
function switchMainTab(tab){const map={orders:'screen-orders',chat:'screen-chat-list',profile:'screen-profile',menu:'screen-menu'};if(map[tab])showScreen(map[tab]);if(tab==='chat'){clearBadge('chat');chatCount=0;renderChatList();}if(tab==='menu')renderMenuTab();if(tab==='orders'){clearBadge('orders');orderCount=0;}if(tab==='profile'){loadMinPrice();loadRatings();}}
function clearBadge(base){['','2','3','4','5'].forEach(s=>{const el=document.getElementById('nb-'+base+s);if(el){el.classList.remove('show');el.textContent='';}});}
function setBadge(base,count){['','2','3','4','5'].forEach(s=>{const el=document.getElementById('nb-'+base+s);if(el){el.textContent=count>9?'9+':count;el.classList.add('show');}});}
function updateDashHeaders(){if(!currentShop)return;['orders','chat','profile','menu'].forEach(t=>{const a=document.getElementById('dash-avi-'+t);const n=document.getElementById('dash-name-'+t);if(a)a.textContent=currentShop.emoji||'🏪';if(n)n.textContent=currentShop.name;});}
function renderShopList(){document.getElementById('seller-list').innerHTML=shops.map((s,i)=>`<div class="seller-login-item" onclick="loginAs(${i})"><div class="sli-avi">${s.emoji||'🏪'}</div><div class="sli-info"><div class="sli-name">${s.name}</div><div class="sli-id">${s.id}</div></div><span style="color:var(--orange);font-weight:900">→</span></div>`).join('');}
function pickEmoji(e){newEmojiSelected=e;document.getElementById('new-shop-emoji').textContent=e;}
function createNewShop(){const name=document.getElementById('new-shop-name').value.trim();const id=document.getElementById('new-shop-id').value.trim();const pin=document.getElementById('new-shop-pin').value.trim()||'1234';if(!name){showToast('Please enter a shop name');return;}if(pin.length<4){showToast('PIN must be at least 4 digits');return;}const shop={name,id:id||'@'+name.toLowerCase().replace(/\s/g,''),emoji:newEmojiSelected,desc:'My shop on MimiEats',pin,menu:[]};shops.push(shop);saveShops();doLogin(shop);}
let _pendingLoginIdx=null;
function loginAs(idx){_pendingLoginIdx=idx;const shop=shops[idx];document.getElementById('pin-shop-name').textContent=shop.name;document.getElementById('pin-input').value='';document.getElementById('pin-error').textContent='';document.getElementById('pin-modal').style.display='flex';setTimeout(()=>document.getElementById('pin-input').focus(),100);}
function submitPin(){const idx=_pendingLoginIdx;if(idx===null)return;const shop=shops[idx];const entered=document.getElementById('pin-input').value.trim();if(entered!==(shop.pin||'1234')){document.getElementById('pin-error').textContent='❌ Wrong PIN. Try again.';document.getElementById('pin-input').value='';document.getElementById('pin-input').focus();return;}document.getElementById('pin-modal').style.display='none';_pendingLoginIdx=null;doLogin(shop);}
function cancelPin(){document.getElementById('pin-modal').style.display='none';_pendingLoginIdx=null;}
function doLogin(shop){currentShop=shop;if(!currentShop.menu)currentShop.menu=[];document.getElementById('prof-name').value=currentShop.name;document.getElementById('prof-id').value=currentShop.id;document.getElementById('prof-desc').value=currentShop.desc||'';profileEmojiSelected=currentShop.emoji||'🏪';document.querySelectorAll('.pep-item').forEach(p=>p.classList.toggle('selected',p.textContent===currentShop.emoji));updateDashHeaders();showScreen('screen-orders');renderMenuTab();startPolling();}
function logout(){if(pollTimer){clearInterval(pollTimer);pollTimer=null;}currentShop=null;orderCount=0;chatCount=0;totalRevenue=0;convHistory={};billRows=[];seenMsgIds=new Set();['orders','chat'].forEach(b=>clearBadge(b));document.getElementById('orders-list-wrap').querySelectorAll('.order-card,.nego-card,.tender-req').forEach(e=>e.remove());const emp=document.getElementById('orders-empty');if(emp)emp.style.display='block';document.getElementById('chat-msgs').innerHTML='';showScreen('screen-login');}
async function loadMinPrice(){if(!currentShop)return;try{const res=await fetch('api.php?action=settings&shop='+encodeURIComponent(currentShop.id));const data=await res.json();shopMinPrice=data.min_price||0;const inp=document.getElementById('min-price-input');if(inp)inp.value=shopMinPrice||'';const st=document.getElementById('min-price-status');if(st)st.textContent=shopMinPrice>0?'Currently set: Rp '+shopMinPrice.toLocaleString()+'. Buyers cannot offer below this.':'No minimum price set.';}catch(e){}}
async function saveMinPrice(){if(!currentShop)return;const val=parseInt(document.getElementById('min-price-input').value)||0;try{const fd=new FormData();fd.append('action','save_settings');fd.append('shop_id',currentShop.id);fd.append('min_price',val);const res=await fetch('api.php',{method:'POST',body:fd});const data=await res.json();if(data.ok){shopMinPrice=val;const st=document.getElementById('min-price-status');if(st)st.textContent=val>0?'✅ Saved! Min price: Rp '+val.toLocaleString():'✅ No minimum price.';showToast(val>0?'🔒 Min price set: Rp '+val.toLocaleString():'Min price removed');}}catch(e){showToast('Failed to save. Check server connection.');}}
async function loadRatings(){if(!currentShop)return;try{const res=await fetch('api.php?action=ratings&shop='+encodeURIComponent(currentShop.id));const data=await res.json();const el=document.getElementById('ratings-list');if(!el)return;if(!Array.isArray(data)||!data.length){el.innerHTML='<p style="font-size:.75rem;color:var(--text3)">No ratings yet</p>';document.getElementById('stat-rating').textContent='—';return;}const avg=(data.reduce((s,r)=>s+r.rating,0)/data.length).toFixed(1);document.getElementById('stat-rating').textContent='⭐ '+avg;el.innerHTML=data.slice(0,5).map(r=>'<div class="rating-item"><div class="rating-stars">'+'⭐'.repeat(r.rating)+'☆'.repeat(5-r.rating)+' <span style="font-weight:900">'+r.rating+'/5</span></div><div style="font-size:.76rem;color:var(--text);margin-top:3px">'+(r.review||'No comment')+'</div><div class="rating-buyer">👤 '+(r.buyer_name||'Anonymous')+' · ID:'+(r.buyer_uid||'—')+' · '+(r.created_at||'').substring(0,10)+'</div></div>').join('');}catch(e){}}
async function loadMessages(){if(!currentShop)return;const sid=encodeURIComponent(currentShop.id||'general');try{const res=await fetch('api.php?shop='+sid);const data=await res.json();if(!Array.isArray(data))return;const newMsgs=data.filter(m=>m.id&&!seenMsgIds.has(String(m.id)));if(!newMsgs.length)return;newMsgs.forEach(m=>{seenMsgIds.add(String(m.id));if(m.sender!=='Buyer')return;const buyer='Buyer';if(!convHistory[buyer])convHistory[buyer]=[];convHistory[buyer].push({text:m.message,sender:'buyer',time:m.created_at||''});if(m.message.includes('🛒 New Order')||m.message.includes('New Order:')){parseAndAddOrder(m.message);setBadge('orders',++orderCount);const tm=m.message.match(/Total: Rp ([0-9.,]+)/);if(tm)totalRevenue+=parseInt(tm[1].replace(/[.,]/g,''))||0;updateRevenueDisplay();showNotifBanner('🛒 New Order!','Tap Orders to respond');}else if(m.message.includes('[Tender Request]')){parseAndAddTender(m.message);setBadge('orders',++orderCount);showNotifBanner('🔨 Tender Request!','A buyer wants competitive offers');}else if(m.message.includes('[Price Negotiation]')){parseAndAddNego(m.message);setBadge('orders',++orderCount);showNotifBanner('💬 Negotiation!','Buyer wants to negotiate price');}else{setBadge('chat',++chatCount);showNotifBanner('💬 New Message!',m.message.substring(0,40));}document.getElementById('stat-chats').textContent=Object.keys(convHistory).length;if(currentScreen==='screen-chat-detail')renderOrderInChat(m.message);});}catch(e){}}
function updateRevenueDisplay(){const el=document.getElementById('stat-revenue');if(el)el.textContent=totalRevenue>0?'Rp '+(totalRevenue/1000).toFixed(0)+'k':'Rp 0';}
function renderChatList(){const el=document.getElementById('chat-list-wrap');const empty=document.getElementById('chat-list-empty');const buyers=Object.keys(convHistory);if(!buyers.length){if(empty)empty.style.display='block';document.querySelectorAll('.chat-conv-item').forEach(e=>e.remove());return;}if(empty)empty.style.display='none';document.querySelectorAll('.chat-conv-item').forEach(e=>e.remove());buyers.forEach(buyer=>{const msgs=convHistory[buyer];const last=msgs[msgs.length-1];const item=document.createElement('div');item.className='chat-conv-item';item.innerHTML='<div class="chat-conv-avi">👤</div><div style="flex:1;min-width:0"><div style="font-weight:800;font-size:.85rem">'+buyer+'</div><div style="font-size:.7rem;color:var(--text2);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-top:2px">'+(last?last.text.substring(0,40)+'...':'No messages')+'</div></div><div style="font-size:.63rem;color:var(--text3)">Now</div>';item.onclick=()=>openChatWith(buyer);el.appendChild(item);});}
function openChatWith(buyer){activeConvBuyer=buyer;document.getElementById('chat-detail-buyer').textContent=buyer;const el=document.getElementById('chat-msgs');el.innerHTML='';(convHistory[buyer]||[]).forEach(m=>{if(m.isBill)renderBillInChat(m.bill);else if(m.message&&(m.message.includes('🛒 New Order')||m.message.includes('New Order:')))renderOrderInChatDirect(m.text||m.message);else renderMsgBubble(m.text||'',m.sender);});showScreen('screen-chat-detail');}
function renderMsgBubble(text,sender){const el=document.getElementById('chat-msgs');const div=document.createElement('div');div.className='chat-msg '+(sender==='buyer'?'buyer-msg':'seller-out');div.innerHTML='<small style="display:block;font-size:.58rem;opacity:.65;margin-bottom:2px;font-weight:700">'+(sender==='buyer'?'Buyer':'You')+'</small>'+text.replace(/\n/g,'<br>')+'<div class="msg-time">'+new Date().toLocaleTimeString('en',{hour:'2-digit',minute:'2-digit'})+'</div>';el.appendChild(div);el.scrollTop=el.scrollHeight;}
function renderOrderInChat(msg){if(msg.includes('🛒 New Order')||msg.includes('New Order:'))renderOrderInChatDirect(msg);else renderMsgBubble(msg,'buyer');}
function renderOrderInChatDirect(msg){const el=document.getElementById('chat-msgs');const div=document.createElement('div');div.className='seller-order-card';const lines=msg.split('\n').filter(l=>l.trim());const items=lines.filter(l=>l.startsWith('-'));const addr=lines.find(l=>l.includes('Deliver to:'))||'';const buyer=lines.find(l=>l.includes('Buyer:'))||'';const total=lines.find(l=>l.includes('Total:'))||'';div.innerHTML='<div class="seller-order-title">🛒 New Order Received!</div>'+items.map(it=>'<div class="seller-order-row"><span>'+it.replace('-','').trim()+'</span></div>').join('')+(addr?'<div style="font-size:.7rem;color:var(--text2);margin-top:6px">📍 '+addr.replace('📍 Deliver to:','').trim()+'</div>':'')+(buyer?'<div style="font-size:.68rem;color:var(--text3)">👤 '+buyer.replace('👤 Buyer:','').trim()+'</div>':'')+(total?'<div class="seller-order-total">'+total+'</div>':'');el.appendChild(div);el.scrollTop=el.scrollHeight;}
function renderBillInChat(bill){if(!bill)return;const el=document.getElementById('chat-msgs');const div=document.createElement('div');div.className='bill-msg';div.innerHTML='<div class="bill-msg-title">🧾 Bill Sent</div>'+bill.items.map(it=>'<div class="bill-msg-row"><span>'+it.name+' ('+it.qty+'x)</span><span>Rp '+it.sub.toLocaleString()+'</span></div>').join('')+'<div class="bill-msg-total">Total: Rp '+bill.total.toLocaleString()+'</div>';el.appendChild(div);el.scrollTop=el.scrollHeight;}
function parseAndAddOrder(msg){const el=document.getElementById('orders-list-wrap');const empty=document.getElementById('orders-empty');if(empty)empty.style.display='none';const lines=msg.split('\n');const items=lines.filter(l=>l.startsWith('-')).map(l=>l.replace('-','').trim());const addr=lines.find(l=>l.includes('Deliver to:'))?.replace('📍 Deliver to:','').trim()||'Not specified';const buyerLine=lines.find(l=>l.includes('Buyer:'))||'';const totalLine=lines.find(l=>l.includes('Total:'))||'';const buyerInfo=buyerLine.replace('👤 Buyer:','').trim();const div=document.createElement('div');div.className='order-card';div.innerHTML='<div class="order-top"><div><div class="order-buyer">🛒 New Order</div>'+(buyerInfo?'<div class="order-buyer-id">👤 '+buyerInfo+'</div>':'')+'</div><span class="status-badge pending">⏳ Pending</span></div><div class="order-items">'+items.join('\n')+'</div><div class="order-addr">📍 <span>'+addr+'</span></div>'+(totalLine?'<div class="order-total">'+totalLine+'</div>':'')+'<div class="order-actions"><button class="btn-accept" onclick="handleOrder(this,\'accepted\')">✓ Accept</button><button class="btn-reject" onclick="handleOrder(this,\'rejected\')">✕ Reject</button><button class="btn-bill" onclick="openBillForOrder(this)">🧾 Bill</button></div>';el.prepend(div);document.getElementById('stat-orders').textContent=parseInt(document.getElementById('stat-orders').textContent||0)+1;}
function handleOrder(btn,status){const card=btn.closest('.order-card');if(!card)return;card.querySelector('.status-badge').textContent=status==='accepted'?'✓ Accepted':'✕ Rejected';card.querySelector('.status-badge').className='status-badge '+status;const actionsDiv=card.querySelector('.order-actions');if(status==='accepted'){actionsDiv.innerHTML='<span class="status-badge accepted">✓ Accepted</span><button class="btn-delivered" onclick="markDelivered(this)">📦 Mark Delivered</button>';sendToAPI('✅ Order Accepted! We are now preparing your food. Estimated delivery: 20–30 mins 🛵');showToast('Order accepted! 🎉');}else{actionsDiv.innerHTML='<span class="status-badge rejected">✕ Rejected</span>';sendToAPI('❌ Order Rejected. Sorry, we cannot accept your order at this time. Please try another seller.');showToast('Order rejected');}}
function markDelivered(btn){const card=btn.closest('.order-card');if(!card)return;card.classList.add('delivered');btn.parentElement.innerHTML='<span class="status-badge delivered">✅ Delivered</span>';sendToAPI('✅ Order Delivered! Your food has arrived. Enjoy your meal! 😋 Please rate us ⭐');showToast('📦 Marked as delivered!');}
function openBillForOrder(btn){switchMainTab('chat');setTimeout(()=>{openChatWith('Buyer');setTimeout(()=>{toggleBillBuilder();if(!document.querySelectorAll('.bill-row-input').length)addBillRow();showToast('Build your bill below 👇');},300);},300);}
function parseAndAddNego(msg){const el=document.getElementById('orders-list-wrap');const empty=document.getElementById('orders-empty');if(empty)empty.style.display='none';const item=msg.match(/Item: (.+)/)?.[1]||'Item';const original=msg.match(/Original: (.+)/)?.[1]||'?';const offer=msg.match(/Buyer.s Offer: (.+)/)?.[1]||'?';const buyerInfo=msg.match(/Buyer: (.+)/)?.[1]||'';const offerNum=parseInt(offer.replace(/[^0-9]/g,''))||0;const isBelowMin=shopMinPrice>0&&offerNum<shopMinPrice;const div=document.createElement('div');div.className='nego-card';div.innerHTML='<div class="order-top"><div><div class="order-buyer" style="color:var(--purple)">💬 Price Negotiation</div>'+(buyerInfo?'<div class="order-buyer-id">👤 '+buyerInfo+'</div>':'')+'</div><span class="status-badge pending">⏳</span></div><div class="nego-offer"><div>Item: <b>'+item+'</b></div><div class="original">Original: '+original+'</div><div class="offered">Buyer offers: '+offer+'</div></div>'+(isBelowMin?'<div class="nego-min-warn">⚠️ Below your minimum price (Rp '+shopMinPrice.toLocaleString()+'). Auto-rejected.</div>':'')+'<div class="order-actions">'+(isBelowMin?'<button class="btn-reject" onclick="respondNego(this,\'rejected\',\''+offer.replace(/'/g,"\\'")+'\')" >✕ Auto-Reject (Below Min)</button>':'<button class="btn-accept" onclick="respondNego(this,\'accepted\',\''+offer.replace(/'/g,"\\'")+'\')">✓ Accept</button><button class="btn-reject" onclick="respondNego(this,\'rejected\',\''+offer.replace(/'/g,"\\'")+'\')">✕ Reject</button>')+'</div>';el.prepend(div);}
function respondNego(btn,status,offer){const card=btn.closest('.nego-card');const offerNum=parseInt(offer.replace(/[^0-9]/g,''));const msg=status==='accepted'?'✅ Nego Accepted! Agreed price: Rp '+offerNum.toLocaleString()+'. Please confirm your order.':'❌ Nego Rejected. Sorry, we cannot accept this price. Please try a higher offer.';sendToAPI(msg);card.querySelector('.order-actions').innerHTML='<span class="status-badge '+(status==='accepted'?'accepted':'rejected')+'">'+(status==='accepted'?'✓ Nego Accepted':'✕ Nego Rejected')+'</span>';showToast(status==='accepted'?'🎉 Nego accepted!':'Nego rejected');}
function parseAndAddTender(msg){const el=document.getElementById('orders-list-wrap');const empty=document.getElementById('orders-empty');if(empty)empty.style.display='none';const food=msg.match(/Food: (.+)/)?.[1]||'Food';const budget=msg.match(/Budget: (.+)/)?.[1]||'?';const note=msg.match(/Note: (.+)/)?.[1]||'-';const buyerInfo=msg.match(/Buyer: (.+)/)?.[1]||'';const div=document.createElement('div');div.className='tender-req';div.innerHTML='<div class="order-top"><div><div style="font-weight:900;font-size:.85rem;color:var(--pink)">🔨 Tender: '+food+'</div>'+(buyerInfo?'<div class="order-buyer-id">👤 '+buyerInfo+'</div>':'')+'</div></div><div style="font-size:.75rem;color:var(--text2);margin-bottom:6px">Budget: <b>'+budget+'</b> | Note: '+note+'</div><div style="font-size:.7rem;color:var(--text3);margin-bottom:8px">Submit your best price to win!</div><div class="bid-input-wrap"><input class="bid-input" type="number" placeholder="Your bid price (Rp)" min="'+(shopMinPrice||0)+'"><button class="btn-bid" onclick="submitBid(this,\''+food.replace(/'/g,"\\'")+'\')" >Bid 🔨</button></div><div class="bid-status" style="margin-top:6px"></div>';el.prepend(div);}
function submitBid(btn,food){const wrap=btn.parentElement;const price=parseInt(wrap.querySelector('input').value);if(!price){showToast('Enter your bid price');return;}if(shopMinPrice>0&&price<shopMinPrice){showToast('Bid must be at least Rp '+shopMinPrice.toLocaleString());return;}const statusEl=btn.closest('.tender-req').querySelector('.bid-status');statusEl.innerHTML='<span style="background:#e8f5e9;color:var(--green);font-size:.72rem;font-weight:800;padding:3px 8px;border-radius:50px">✓ Bid: Rp '+price.toLocaleString()+'</span>';sendToAPI('[Bid Submitted]\nShop: '+(currentShop?.name||'Seller')+'\nFood: '+food+'\nBid Price: Rp '+price.toLocaleString());wrap.querySelector('input').value='';showToast('Bid Rp '+price.toLocaleString()+' sent!');}
function toggleBillBuilder(){const bb=document.getElementById('bill-builder');const open=bb.classList.toggle('open');if(open&&!document.querySelectorAll('.bill-row-input').length)addBillRow();}
function addBillRow(){const rowId=Date.now();billRows.push(rowId);const container=document.getElementById('bill-rows');const row=document.createElement('div');row.className='bill-row-input';row.id='brow-'+rowId;row.innerHTML='<input type="text" placeholder="Item" oninput="updateBillTotal()"><input type="number" placeholder="Qty" min="1" value="1" oninput="updateBillTotal()"><input type="number" placeholder="Price" min="0" oninput="updateBillTotal()"><button class="btn-rm" onclick="removeBillRow('+rowId+')">✕</button>';container.appendChild(row);updateBillTotal();}
function removeBillRow(id){document.getElementById('brow-'+id)?.remove();billRows=billRows.filter(r=>r!==id);updateBillTotal();}
function updateBillTotal(){let total=0;document.querySelectorAll('.bill-row-input').forEach(row=>{const inputs=row.querySelectorAll('input');total+=(parseFloat(inputs[1].value)||0)*(parseFloat(inputs[2].value)||0);});document.getElementById('bill-total-preview').textContent='Total: Rp '+total.toLocaleString('id-ID');}
function sendBill(){const rows=document.querySelectorAll('.bill-row-input');if(!rows.length)return;let lines=[];let total=0;let valid=true;const billData={items:[],total:0};rows.forEach(row=>{const inputs=row.querySelectorAll('input');const name=inputs[0].value.trim();const qty=parseFloat(inputs[1].value)||0;const price=parseFloat(inputs[2].value)||0;if(!name||!qty||!price){valid=false;return;}const sub=qty*price;total+=sub;lines.push('- '+name+' x'+qty+' = Rp '+sub.toLocaleString());billData.items.push({name,qty,price,sub});});if(!valid||!lines.length){showToast('Fill in all item details');return;}billData.total=total;lines.push('Total: Rp '+total.toLocaleString());const msg='[Bill]\n'+lines.join('\n');sendToAPI(msg);if(!convHistory['Buyer'])convHistory['Buyer']=[];convHistory['Buyer'].push({text:msg,sender:'seller',isBill:true,bill:billData});renderBillInChat(billData);document.getElementById('bill-rows').innerHTML='';billRows=[];document.getElementById('bill-builder').classList.remove('open');showToast('🧾 Bill sent!');}
function clearThisChat(){
  if(!confirm('Clear chat with ' + activeConvBuyer + '?')) return;
  convHistory[activeConvBuyer] = [];
  seenMsgIds = new Set();
  document.getElementById('chat-msgs').innerHTML = '';
  var fd=new FormData();
  fd.append('action','clear_chat');
  fd.append('shop_id',currentShop?currentShop.id:'general');
  fetch('api.php',{method:'POST',body:fd}).catch(function(e){});
  showToast('💬 Chat cleared!');
}
function sendReply(){const input=document.getElementById('chat-reply-input');const text=input.value.trim();if(!text)return;renderMsgBubble(text,'seller');if(!convHistory[activeConvBuyer])convHistory[activeConvBuyer]=[];convHistory[activeConvBuyer].push({text,sender:'seller'});sendToAPI(text);input.value='';}
async function sendToAPI(message){if(!currentShop)return;try{const fd=new FormData();fd.append('sender','Seller');fd.append('message',message);fd.append('shop_id',currentShop?.id||'general');await fetch('api.php',{method:'POST',body:fd});}catch(e){console.error('sendToAPI error:',e);}}
function selectProfileEmoji(el){document.querySelectorAll('.pep-item').forEach(e=>e.classList.remove('selected'));el.classList.add('selected');profileEmojiSelected=el.textContent;}
function saveProfile(){if(!currentShop)return;const name=document.getElementById('prof-name').value.trim()||currentShop.name;const id=document.getElementById('prof-id').value.trim()||currentShop.id;const desc=document.getElementById('prof-desc').value.trim();currentShop.name=name;currentShop.id=id;currentShop.desc=desc;currentShop.emoji=profileEmojiSelected;const idx=shops.findIndex(s=>s.id===currentShop.id||s.name===name);if(idx>=0)shops[idx]=currentShop;saveShops();updateDashHeaders();showToast('✅ Profile saved!');}
function renderMenuTab(){if(!currentShop)return;const wrap=document.getElementById('menu-list-wrap');const menu=currentShop.menu||[];wrap.innerHTML='<div style="padding:16px"><div style="font-weight:900;font-size:1rem;margin-bottom:12px">🍽️ Your Menu ('+menu.length+' items)</div>'+menu.map((m,i)=>'<div style="background:#fff;border-radius:14px;padding:12px;margin-bottom:10px;box-shadow:0 2px 8px rgba(0,0,0,.07);display:flex;gap:10px;align-items:center"><div style="width:56px;height:56px;border-radius:10px;overflow:hidden;background:#eee;flex-shrink:0"><img src="'+m.img+'" style="width:100%;height:100%;object-fit:cover" onerror="this.style.display=\'none\'"></div><div style="flex:1"><div style="font-weight:900;font-size:.88rem">'+m.name+'</div><div style="font-size:.73rem;color:#888">'+m.cat+'</div><div style="font-weight:900;color:#f57c00;font-size:.85rem">Rp '+m.price.toLocaleString()+'</div></div><button onclick="deleteMenuItem('+i+')" style="background:#fce4ec;color:#e91e8c;border:none;width:30px;height:30px;border-radius:50%;font-size:.85rem;cursor:pointer;font-weight:900">✕</button></div>').join('')+'<div style="background:#fff;border-radius:14px;padding:16px;margin-top:14px;box-shadow:0 2px 8px rgba(0,0,0,.07)"><div style="font-weight:900;font-size:.88rem;margin-bottom:10px;color:#f06292">➕ Add Menu Item</div><input id="new-menu-name" placeholder="Menu name" style="width:100%;border:1.5px solid #eee;border-radius:10px;padding:9px 12px;font-family:\'Nunito\',sans-serif;font-size:.83rem;margin-bottom:8px;outline:none"><input id="new-menu-price" type="number" placeholder="Price (e.g. 20000)" style="width:100%;border:1.5px solid #eee;border-radius:10px;padding:9px 12px;font-family:\'Nunito\',sans-serif;font-size:.83rem;margin-bottom:8px;outline:none"><select id="new-menu-cat" style="width:100%;border:1.5px solid #eee;border-radius:10px;padding:9px 12px;font-family:\'Nunito\',sans-serif;font-size:.83rem;margin-bottom:8px;outline:none;background:#fff"><option value="rice">🍛 Rice</option><option value="noodles">🍜 Noodles</option><option value="spicy">🌶️ Spicy</option><option value="sweet">🍰 Sweet</option><option value="savory">🧂 Savory</option><option value="drinks">🥤 Drinks</option><option value="snacks">🍢 Snacks</option></select><input id="new-menu-img" placeholder="Photo URL" style="width:100%;border:1.5px solid #eee;border-radius:10px;padding:9px 12px;font-family:\'Nunito\',sans-serif;font-size:.83rem;margin-bottom:12px;outline:none"><button onclick="addMenuItem()" style="width:100%;background:linear-gradient(135deg,#f06292,#ffb74d);color:#fff;border:none;padding:11px;border-radius:10px;font-family:\'Nunito\',sans-serif;font-weight:900;font-size:.88rem;cursor:pointer">Save ✓</button></div></div>';updateDashHeaders();}
function addMenuItem(){const name=document.getElementById('new-menu-name').value.trim();const price=parseInt(document.getElementById('new-menu-price').value)||0;const cat=document.getElementById('new-menu-cat').value;const img=document.getElementById('new-menu-img').value.trim();if(!name||!price){showToast('Please fill in name and price!');return;}if(!currentShop.menu)currentShop.menu=[];currentShop.menu.push({name,price,cat,img:img||'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=300&h=200&fit=crop'});saveShops();showToast('✅ Menu item added!');renderMenuTab();}
function deleteMenuItem(idx){if(!currentShop.menu)return;currentShop.menu.splice(idx,1);saveShops();showToast('Menu item removed');renderMenuTab();}
async function clearAllOrders(){if(!confirm('Clear all orders for '+currentShop?.name+'?'))return;try{const fd=new FormData();fd.append('action','clear_orders');fd.append('shop_id',currentShop?.id||'general');await fetch('api.php',{method:'POST',body:fd});}catch(e){}orderCount=0;totalRevenue=0;updateRevenueDisplay();document.getElementById('orders-list-wrap').querySelectorAll('.order-card,.nego-card,.tender-req').forEach(e=>e.remove());const emp=document.getElementById('orders-empty');if(emp)emp.style.display='block';clearBadge('orders');showToast('📦 Orders cleared!');}
async function clearAllChat(){if(!confirm('Clear all chat history for '+currentShop?.name+'?'))return;try{const fd=new FormData();fd.append('action','clear_chat');fd.append('shop_id',currentShop?.id||'general');await fetch('api.php',{method:'POST',body:fd});}catch(e){}document.getElementById('chat-msgs').innerHTML='';convHistory={};seenMsgIds=new Set();chatCount=0;renderChatList();clearBadge('chat');showToast('💬 Chat cleared!');}
function showNotifBanner(title,sub){const existing=document.querySelector('.notif-banner-s');if(existing)existing.remove();const banner=document.createElement('div');banner.className='notif-banner-s';banner.style.cssText='position:fixed;top:70px;left:50%;transform:translateX(-50%);background:#fff;border-radius:14px;padding:12px 16px;box-shadow:0 4px 20px rgba(0,0,0,.15);display:flex;gap:10px;align-items:center;z-index:9999;max-width:360px;width:90%;border-left:4px solid var(--orange)';banner.innerHTML='<div><div style="font-weight:900;font-size:.85rem">'+title+'</div><div style="font-size:.72rem;color:#666;margin-top:2px">'+sub+'</div></div><button onclick="this.parentElement.remove()" style="margin-left:auto;background:none;border:none;font-size:1rem;cursor:pointer;color:#aaa">✕</button>';document.body.appendChild(banner);setTimeout(()=>banner.remove&&banner.remove(),5000);}
function showToast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');setTimeout(()=>t.classList.remove('show'),2500);}
async function startPolling(){if(pollTimer)clearInterval(pollTimer);seenMsgIds=new Set();orderCount=0;chatCount=0;totalRevenue=0;try{const sid=encodeURIComponent(currentShop.id||'general');const res=await fetch('api.php?shop='+sid);const data=await res.json();if(Array.isArray(data))data.forEach(m=>{if(m.id)seenMsgIds.add(String(m.id));});}catch(e){}await loadMinPrice();pollTimer=setInterval(loadMessages,2500);}
window.onload=()=>{renderShopList();};
</script>
</body>
</html>