
    body {
  background: #dd3f3e;
  font-family: "Montserrat", sans-serif;
  margin: 0;
  padding: 0;
}

.ticket {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 700px;
  margin: 20px auto;

  .stub,
  .check {
    box-sizing: border-box;
  }
}

.stub {
  background: #ef5658;
  height: 250px;
  width: 250px;
  color: white;
  padding: 20px;
  position: relative;

  &:before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    border-top: 20px solid #dd3f3e;
    border-left: 20px solid #ef5658;
    width: 0;
  }
  &:after {
    content: "";
    position: absolute;
    bottom: 0;
    right: 0;
    border-bottom: 20px solid #dd3f3e;
    border-left: 20px solid #ef5658;
    width: 0;
  }

  .top {
    display: flex;
    align-items: center;
    height: 40px;
    text-transform: uppercase;

    .line {
      display: block;
      background: #fff;
      height: 40px;
      width: 3px;
      margin: 0 20px;
    }
    .num {
      font-size: 10px;
      span {
        color: #000;
      }
    }
  }
  .number {
    position: absolute;
    left: 40px;
    font-size: 150px;
  }
  .invite {
    position: absolute;
    left: 150px;
    bottom: 45px;
    color: #000;
    width: 20%;

    &:before {
      content: "";
      background: #fff;
      display: block;
      width: 40px;
      height: 3px;
      margin-bottom: 5px;
    }
  }
}

.check {
  background: #fff;
  height: 250px;
  width: 450px;
  padding: 40px;
  position: relative;

  &:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    border-top: 20px solid #dd3f3e;
    border-right: 20px solid #fff;
    width: 0;
  }
  &:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    border-bottom: 20px solid #dd3f3e;
    border-right: 20px solid #fff;
    width: 0;
  }

  .big {
    font-size: 80px;
    font-weight: 900;
    line-height: 0.8em;
  }
  .number {
    position: absolute;
    top: 50px;
    right: 50px;
    color: #ef5658;
    font-size: 40px;
  }
  .info {
    display: flex;
    justify-content: flex-start;

    font-size: 12px;
    margin-top: 20px;
    width: 100%;

    section {
      margin-right: 50px;
      &:before {
        content: "";
        background: #ef5658;
        display: block;
        width: 40px;
        height: 3px;
        margin-bottom: 5px;
      }
      .title {
        font-size: 10px;
        text-transform: uppercase;
      }
    }
  }
}

