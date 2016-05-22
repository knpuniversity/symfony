var NoteSection = React.createClass({
    getInitialState: function() {
        return {
            notes: []
        }
    },

    componentDidMount: function() {
        this.loadNotesFromServer();
        setInterval(this.loadNotesFromServer, 2000);
    },

    loadNotesFromServer: function() {
        $.ajax({
            url: '/genus/octopus/notes',
            success: function (data) {
                this.setState({notes: data.notes});
            }.bind(this)
        });
    },

    render: function() {
        return (
            <div>
                <div className="notes-container">
                    <h2 className="notes-header">Notes</h2>
                    <div><i className="fa fa-plus plus-btn"></i></div>
                </div>
                <NoteList notes={this.state.notes} />
            </div>
        );
    }
});

var NoteList = React.createClass({
    render: function() {
        var noteNodes = this.props.notes.map(function(note) {
            return (
                <NoteBox username={note.username} avatarUri={note.avatarUri} date={note.date} key={note.id}>{note.note}</NoteBox>
            );
        });

        return (
            <section id="cd-timeline">
                {noteNodes}
            </section>
        );
    }
});

var NoteBox = React.createClass({
    render: function() {
        return (
            <div className="cd-timeline-block">
                <div className="cd-timeline-img">
                    <img src={this.props.avatarUri} className="img-circle" alt="Leanna!" />
                </div>
                <div className="cd-timeline-content">
                    <h2><a href="#">{this.props.username}</a></h2>
                    <p>{this.props.children}</p>
                    <span className="cd-date">{this.props.date}</span>
                </div>
            </div>
        );
    }
});

window.NoteSection = NoteSection;
